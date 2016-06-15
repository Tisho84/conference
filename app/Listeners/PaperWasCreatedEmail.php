<?php

namespace App\Listeners;

use App\Classes\Template;
use App\EmailTemplate;
use App\Events\PaperWasCreated;
use App\Settings;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaperWasCreatedEmail// implements ShouldQueue
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
     * @param  PaperWasCreated $event
     * @return void
     */
    public function handle(PaperWasCreated $event)
    {
        $template = new Template();
        $settings = $event->paper->department->settings()->key('email_add_paper');
        if (isset($settings->value) && $settings->value) {
            $emailTemplate = EmailTemplate::findOrFail($settings->value);

            $emailTemplate->body = $template->parser($emailTemplate->body, [
                'name' => $event->paper->user->name,
                'time' => $event->paper->created_at,
                'link' => buildPaperLink($event->paper)
            ]);

            $this->mailer->send('layouts.partials.email', ['body' => $emailTemplate->body], function ($message) use ($emailTemplate, $event) {
                $message->subject($emailTemplate->subject);
                $message->to($event->paper->user->email);
            });
        }
    }
}
