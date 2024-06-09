<?php

namespace App\Mail;

use App\Models\Expense;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExpenseRejectedMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $expense;

    /**
     * Create a new message instance.
     */
    public function __construct(Expense $expense)
    {
        //
        $this->expense = $expense;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Expense Rejected Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'expenses.mails.expense-rejected-mail',
            with: [
                'expenseTitle'=>$this->expense->title,
                'description'=>$this->expense->description, 
                'dateCreated'=>$this->expense->created_at->format('Y-m-d'),
                
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
