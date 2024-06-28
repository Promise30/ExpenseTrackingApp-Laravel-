<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Expense;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\ExpenseCreatedMail;
use App\Mail\ExpenseUpdatedMail;
use App\Mail\ExpenseApprovedMail;
use App\Mail\ExpenseRejectedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ExpenseCreatedNotification;
use App\Notifications\ExpenseDeletedNotification;
use App\Notifications\ExpenseUpdatedNotification;
use App\Notifications\ExpenseApprovedNotification;
use App\Notifications\ExpenseRejectedNotification;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        $dateFilter = $request->date_filter;
        $statusFilter = $request->status_filter;
        $search = $request->search;

        if(auth()->user()->hasRole('Administrator')){
            $query = Expense::query();
        }
        else{
            $query = Expense::query()->where('user_id', $userId);
        }
        if($dateFilter){
            $query = match($dateFilter) {
                'today' => $query->whereDate('created_at', Carbon::today()),
                'yesterday' => $query->whereDate('created_at', Carbon::yesterday()),
                'this_week' => $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]),
                'last_week' => $query->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]),
                'this_month' => $query->whereMonth('created_at', Carbon::now()->month),
                'last_month' => $query->whereMonth('created_at', Carbon::now()->subMonth()->month),
                'this_year' => $query->whereYear('created_at', Carbon::now()->year),
                'last_year' => $query->whereYear('created_at', Carbon::now()->subYear()->year),
                default => $query,
            };
        }
        if ($statusFilter) {
            $query = $query->where('status', $statusFilter);
        }
        if ($search) {
            $query = $query->where('title', 'LIKE', '%' . $search . '%');
        }

        $expenses = $query->latest()->paginate(5)->appends(['date_filter' => $dateFilter, 'status_filter' => $statusFilter, 'search'=> $search]);
        return view('expenses.index', compact('expenses', 'dateFilter', 'statusFilter', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        try {
            $validated = $request->validated();

            if ($request->file('receipt')) {
                $extension = $request->file('receipt')->extension();
                $contents = file_get_contents($request->file('receipt'));
                $filename = Str::random(25);
                $path = "attachments/$filename.$extension";
                Storage::disk('public')->put($path, $contents);
                $validated['receipt'] = $path;
            }

            // Create a new expense record
            $expense = auth()->user()->expenses()->create($validated);

            // Notify the admins
            $admins = User::whereHas('roles', function ($query) {
                $query->where('name', 'Administrator');
            })->get();

            foreach ($admins as $recipient) {
                $recipient->notify(new ExpenseCreatedNotification($expense));
                Mail::to($recipient)->queue(new ExpenseCreatedMail($expense));
            }
            session()->flash('alert_type', 'success');
            session()->flash('alert_message', 'Expense created successfully');
        } catch (\Exception $e) {
            
            session()->flash('alert_type', 'error');
            session()->flash('alert_message', 'An error occurred while creating the expense: ' . $e->getMessage());
        }

        return redirect()->route('expense.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        //
        return view('expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        if (auth()->user()->hasRole('Administrator')) {
            $expense->update(['status' => $request->status]);
            if ($expense['status'] === 'approved') {
                // Send a databse notification and mail
                //$expense->user->notify(new ExpenseApprovedNotification($expense));
                Mail::to($expense->user->email)->queue(new ExpenseApprovedMail($expense));
            } elseif ($expense['status'] === 'rejected') {
                //$expense->user->notify(new ExpenseRejectedNotification($expense));
                Mail::to($expense->user->email)->queue(new ExpenseRejectedMail($expense));
            }
            session()->flash('alert_type', 'success');
            session()->flash('alert_message', 'Expense status updated successfully');
        }
        else{
            $validatedData = $request->validated();
            if($request->file('receipt')) {
                Storage::disk('public')->delete($expense->receipt);
                $extension = $request->file('receipt')->extension();
                $contents = file_get_contents($request->file('receipt'));
                $filename = Str::random(25);
                $path = "attachments/$filename.$extension";
                Storage::disk('public')->put($path, $contents);
                $validatedData['receipt'] = $path;
            }
            $expense->update($validatedData);
            session()->flash('alert_type', 'success');
            session()->flash('alert_message', 'Expense updated successfully');
        }
        return redirect()->route('expense.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        try {
            $expense->delete();
            session()->flash('alert_type', 'success');
            session()->flash('alert_message', 'Expense deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('alert_type', 'error');
            session()->flash('alert_message', 'Failed to delete expense. Please try again.');
        }
        return redirect(route('expense.index'));
    }

}
