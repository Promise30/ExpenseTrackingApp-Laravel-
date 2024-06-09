<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    //
    public function allNotifications()
    {
        //$notificationCount = auth()->user()->unreadNotifications()->count();
        // If you need only notifications that are unread : use unreadNotification()
        // else: use notifications()
        $notifications = auth()->user()->notifications()->latest()->paginate(10);
        //$notificationCount = $notifications->whereNull('read_at')->count();
        return view('expenses.expense-notifications', compact('notifications'));
    }
    public function read($id){
        $notification = auth()->user()->notifications()->findOrfail($id);
        $notification->markAsRead();

        $expenseId = $notification->data['expense_id'];
        return redirect()->route('expense.show', $expenseId);
    }
    public function markAllAsRead(){
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->back();
    }

}
