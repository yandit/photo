<?php

namespace Modules\UserManagement\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminForgotPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $params;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Reset Password Request')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->markdown('usermanagement::emails.admin.forgot-password', $this->params);
    }
}
