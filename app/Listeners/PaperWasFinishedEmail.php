<?php

namespace App\Listeners;

use App\Classes\Template;
use App\EmailTemplate;
use App\Events\PaperWasFinished;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaperWasFinishedEmail
{
    /*
     * Create the event listener.
     * @params Mailer $mailer
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  PaperWasFinished  $event
     * @return void
     */
    public function handle(PaperWasFinished $event)
    {
        $template = new Template();
        $settings = $event->paper->department->settings()->key('email_finished_paper');
        if (isset($settings->value) && $settings->value) {
            $emailTemplate = EmailTemplate::findOrFail($settings->value);

            $emailTemplate->body = $template->parser($emailTemplate->body, [
                'name' => $event->paper->user->name,
                'time' => $event->paper->reviewed_at,
                'link' => buildPaperLink($event->paper)
            ]);

            $this->mailer->send('layouts.partials.email', ['body' => $emailTemplate->body], function ($message) use ($emailTemplate, $event) {
                $message->subject($emailTemplate->subject);
                $message->to($event->paper->user->email);
            });
        }
    }
}
