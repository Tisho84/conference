<?php

namespace App\Listeners;

use App\Classes\Template;
use App\EmailTemplate;
use App\Events\ReviewerPaperSet;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReviewerPaperSetEmail
{
    /*
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  ReviewerPaperSet  $event
     * @return void
     */
    public function handle(ReviewerPaperSet $event)
    {
        $template = new Template();
        $settings = $event->paper->department->settings()->key('email_reviewer_paper');
        if (isset($settings->value) && $settings->value && $event->paper->reviewer) {
            $emailTemplate = EmailTemplate::findOrFail($settings->value);
            $emailTemplate->body = $template->parser($emailTemplate->body, [
                'name' => $event->paper->reviewer->name,
                'link' => buildPaperLink($event->paper)
            ]);

            $this->mailer->send('layouts.partials.email', ['body' => $emailTemplate->body], function ($message) use ($emailTemplate, $event) {
                $message->subject($emailTemplate->subject);
                $message->to($event->paper->reviewer->email);
            });
        }
    }
}
