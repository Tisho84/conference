<?php

namespace App\Listeners;

use App\Classes\Template;
use App\EmailTemplate;
use App\Events\PaperWasCreated;
use Illuminate\Mail\Mailer;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaperWasCreatedNotification
{
    public $mailer;
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
     * @param  PaperWasCreated  $event
     * @return void
     */
    public function handle($event)
    {
        $template = new Template();
        $department = $event->paper->department;
        $settings = $department->settings()->key('email_notification');
        if (isset($settings->value) && $settings->value) {
            $users = User::where('department_id', $department->id)->whereHas('type.access', function($query) {
                $query->where('access_id', 12);
            })->get();

            if (count($users)) {
                $emailTemplate = EmailTemplate::findOrFail($settings->value);
                $emails = $users->pluck('email')->toArray();

                $body = $template->parser($emailTemplate->body, [
                    'author_name' => $event->paper->user->name,
                    'time' => $event->paper->updated_at,
                    'operation' => $event->operation,
                    'link' => action('Admin\PaperController@show', [$event->paper->id])
                ]);

                $this->mailer->send('layouts.partials.email', ['body' => $body], function ($message) use ($emailTemplate, $emails) {
                    $message->subject($emailTemplate->subject);
                    $message->bcc($emails);
                });
            }
        }
    }
}
