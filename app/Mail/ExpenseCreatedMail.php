<?php

namespace App\Mail;

use App\Models\Expense;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExpenseCreatedMail extends Mailable
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
            subject: 'New Expense Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'expenses.mails.expense-detail-mail',
            with: [
                'expenseTitle'=>$this->expense->title,
                'description'=>$this->expense->description, 
                'dateCreated'=>$this->expense->created_at->format('Y-m-d'),
                'creator' =>$this->expense->user->name
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
        $filePath = storage_path('app/public/' . $this->expense->receipt);
        return [
            Attachment::fromPath($filePath)
        ];

    }
}
