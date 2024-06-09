<?php

namespace App\Notifications;

use App\Models\Expense;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ExpenseApprovedNotification extends Notification
{
    use Queueable;
    protected $expense;

    /**
     * Create a new notification instance.
     */
    public function __construct(Expense $expense)
    {
        //
        $this->expense = $expense;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Your expense has been approved.')
                    ->action('View Expense', url('/expenses/' . $this->expense->id))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
            return [
                'message' => 'Your expense titled "' . $this->expense->title . '" has been approved.',
                'expense_id' => $this->expense->id,
                'title' => $this->expense->title,
            ];
    }
}
