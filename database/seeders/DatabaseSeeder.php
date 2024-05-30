<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Expense;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);  */
        // Fake data for today
        Expense::factory(6)->create([
            'created_at' => Carbon::today(),
        ]);

        // Fake data for yesterday
       Expense::factory(6)->create([
            'created_at' => Carbon::yesterday(),
        ]);

        // Fake data for this week
        Expense::factory(6)->create([
                    'created_at' => Carbon::now()->startOfWeek(),
                ])->each(function ($expense) {
                    $expense->created_at = $expense->created_at->addMinutes(rand(1, 1440 * 6));
                    $expense->save();
                });

        // Fake data for last week
        Expense::factory(6)->create([
                    'created_at' => Carbon::now()->subWeek()->startOfWeek(),
                ])->each(function ($expense) {
                    $expense->created_at = $expense->created_at->addMinutes(rand(1, 1440 * 6));
                    $expense->save();
                });  
                
        // Fake data for this month
        Expense::factory(6)->create([
            'created_at' => Carbon::now()->startOfMonth(),
        ])->each(function ($expense) {
            $expense->created_at = $expense->created_at->addMinutes(rand(1, 1440 * 30));
            $expense->save();
        });

       // Fake data for last month
       Expense::factory(6)->create([
                    'created_at' => Carbon::now()->subMonth()->startOfMonth(),
                ])->each(function ($expense) {
                    $expense->created_at = $expense->created_at->addMinutes(rand(1, 1440 * 30));
                    $expense->save();
                });

        // Fake data for this year
        Expense::factory(6)->create([
                    'created_at' => Carbon::now()->startOfYear(),
                ])->each(function ($expense) {
                    $expense->created_at = $expense->created_at->addMinutes(rand(1, 1440 * 365));
                    $expense->save();
                });

        // Fake data for last year
        Expense::factory(6)->create([
                    'created_at' => Carbon::now()->subYear()->startOfYear(),
                ])->each(function ($expense) {
                    $expense->created_at = $expense->created_at->addMinutes(rand(1, 1440 * 365));
                    $expense->save();
            });        

    }
}
