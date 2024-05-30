<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $userId = auth()->user()->id;
        $dateFilter = $request->date_filter;
        $query = Expense::query()->where('user_id', $userId);
        
        switch($dateFilter){
            
            case 'today':
                $query->whereDate('created_at',Carbon::today());
                break;
            case 'yesterday':
                $query->wheredate('created_at',Carbon::yesterday());
                break;
            case 'this_week':
                $query->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
                break;
            case 'last_week':
                $query->whereBetween('created_at',[Carbon::now()->subWeek(),Carbon::now()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at',Carbon::now()->month);
                break;
            case 'last_month':
                $query->whereMonth('created_at',Carbon::now()->subMonth()->month);
                break;
            case 'this_year':
                $query->whereYear('created_at',Carbon::now()->year);
                break;
            case 'last_year':
                $query->whereYear('created_at',Carbon::now()->subYear()->year);
                break;                       
            }
        $expenses = $query->paginate(5);
        return view('expenses.index', compact('expenses', 'dateFilter'));
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
        $expense = Expense::create([
            'title'       => $request->title,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'category' => $request->category,
            'user_id'     => auth()->id(),
        ]);
        if($request->file('receipt')){
            $extension      = $request->file('receipt')->extension();
            $contents = file_get_contents($request->file('receipt'));
            $filename = Str::random(25);
            $path     = "attachments/$filename.$extension";
            Storage::disk('public')->put($path, $contents);
            $expense->update(['receipt' => $path]);
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
        //
        $expense->update($request->except('receipt'));

        if ($request->file('receipt')) {
            Storage::disk('public')->delete($expense->receipt);
            $extension      = $request->file('receipt')->extension();
            $contents = file_get_contents($request->file('receipt'));
            $filename = Str::random(25);
            $path     = "attachments/$filename.$extension";
            Storage::disk('public')->put($path, $contents);
            $expense->update(['receipt' => $path]);
           
        }
        return redirect(route('expense.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
        $expense->delete();
        return redirect(route("expense.index"));
    }
}
