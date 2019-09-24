<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FeedbackMail extends Mailable
{
    use Queueable, SerializesModels;
    public $email, $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $content)
    {
        // lấy nội dung từ form truyền vào template mail sau đó gửi cho admin
        $this->email = $email;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.feedback');
    }
}
