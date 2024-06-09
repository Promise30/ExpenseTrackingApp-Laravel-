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
        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }
        if ($search) {
            $query->where('title', 'LIKE', '%' . $search . '%');
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
        //
        $user = auth()->user();
        $validated = $request->validated();
        if($request->file('receipt')){
            $extension = $request->file('receipt')->extension();
            $contents = file_get_contents($request->file('receipt'));
            $filename = Str::random(25);
            $path = "attachments/$filename.$extension";
            Storage::disk('public')->put($path, $contents);
            $validated['receipt'] = $path;
        }
        // create a new expense record
        $expense = auth()->user()->expenses()->create( $validated );   

        // Notify the admins
        // $user->notify(new ExpenseCreatedNotification($expense));
        $admins = User::whereHas('roles', function ($query) {$query->where('name', 'Administrator');})->get();
  
        Notification::send($admins, new ExpenseCreatedNotification($expense));

        // Send mail admins
        // Mail::to($request->user())->send(new ExpenseCreated($expense));
        foreach ($admins as $recipient) {
            Mail::to($recipient)->send(new ExpenseCreatedMail($expense));
        }

        return redirect()->route('expense.index')->with('success','Expense created successfully');

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
        //
        //$expense->update($request->validated());
        //$validatedData = $request->validated();

        if (auth()->user()->hasRole('Administrator')) {
            
            $request->validate([
                'status' => 'required|in:pending,approved,rejected',
            ]);
            $expense->update(['status' => $request->status]);
            if ($expense['status'] === 'approved') {
                $expense->user->notify(new ExpenseApprovedNotification($expense));
                Mail::to($request->user())->send(new ExpenseApprovedMail($expense));
            } elseif ($expense['status'] === 'rejected') {
                $expense->user->notify(new ExpenseRejectedNotification($expense));
                Mail::to($request->user())->send(new ExpenseRejectedMail($expense));
            }
        }
        else{
            $expense->update($request->except('receipt'));
            if($request->file('receipt')) {
                Storage::disk('public')->delete($expense->receipt);
                $extension      = $request->file('receipt')->extension();
                $contents = file_get_contents($request->file('receipt'));
                $filename = Str::random(25);
                $path     = "attachments/$filename.$extension";
                Storage::disk('public')->put($path, $contents);
                $expense->update(['receipt' => $path]);
            }
           
        }
        // if ($request->hasFile('receipt')) {
        //     // Delete the previous receipt file if it exists
        //     if ($expense->receipt && Storage::disk('public')->exists($expense->receipt)) {
        //         Storage::disk('public')->delete($expense->receipt);
        //     }
    
        //     // Store the new receipt file
        //     $extension = $request->file('receipt')->extension();
        //     $contents = file_get_contents($request->file('receipt'));
        //     $filename = Str::random(25);
        //     $path = "attachments/$filename.$extension";
        //     Storage::disk('public')->put($path, $contents);
    
        //     // Update the 'receipt' field with the new file path
        //     $validatedData['receipt'] = $path;
        // }
    
        // $expense->update($validatedData);
        // $expense->status = $request->input('status'); // Update the status field
        // $expense->save();
        //auth()->user()->notify(new ExpenseUpdatedNotification($expense));
        // Send notification
        //$admins = User::whereHas('roles', function ($query) {$query->where('name', 'admin');})->get();
  
        //Notification::send($admins, new ExpenseUpdatedNotification($expense));

        //Send mail

        //foreach ($admins as $recipient) {
          //  Mail::to($recipient)->send(new ExpenseUpdatedMail($expense));
        //}

        
        return redirect()->route('expense.index')->with('success','Expense Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
        $expense->delete();
        //auth()->user()->notify(new ExpenseDeletedNotification($expense));

        return redirect(route("expense.index"));
    }

    // public function updateStatus(Expense $expense, $status)
    // {
    //     // if (!Auth::user()->hasRole('Administrator')) {
    //     //     abort(403, 'Unauthorized action.');
    //     // }

    //     $validStatus = ['approved', 'rejected'];
    //     if (!in_array($status, $validStatus)) {
    //         abort(400, 'Invalid status value.');
    //     }

    //     $expense->update(['status' => $status]);

    //     // Notify the user or perform any other necessary actions

    //     return redirect()->route('expense.show', $expense->id);
    // }
}
