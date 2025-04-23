<?php

namespace Lareon\Modules\Comment\App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Lareon\CMS\App\Mail\AnnouncementMail;
use Lareon\CMS\App\Models\User;
use Lareon\Modules\Comment\App\Models\Comment;
use Lareon\Modules\Questionnaire\App\Mail\ReceivedAnnouncementMail;

class NewCommentListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $comment = $event->comment;

        $emails = config('lareon.comment.notifyEmail' ?? []);

        if (count($emails)) $this->sendEmailsToAdmins($emails, $comment);

    }


    /**
     * Send notification emails.
     */
    private function sendEmailsToAdmins(array $emails, Comment $comment): void
    {
        $subject = __('a new comment is submitted');
        $heading = __('hi');
        $introduction = [
            __('a new comment is submitted in the page :title', ['title' => $comment->title]),
            __('please check the inbox and take the necessary actions'),
        ];
        $action = [
            'title' => __('check it'),
            'url' => route('admin.comments.index'),
        ];
        $explanation = $this->generateEmailTable($comment);
        $content = [
            'subject' => $subject,
            'heading' => $heading,
            'introduction' => $introduction,
            'action' => $action,
            'explanation' => $explanation,
        ];
        $mail = new AnnouncementMail($subject, $content);

        $mail->onQueue('emails');

        foreach ($emails as $email) {
            Mail::to($email)->queue($mail);
        }
    }

    /**
     * Generate HTML table for email content.
     */
    private function generateEmailTable(Comment $comment): string
    {
        $tableRows = '';
        $isEvenRow = true;

        $details = [
            'message' => $comment->message,
            'page' => $comment->title,
            'email' => $comment->name,
            'name' => $comment->name,
        ];


        foreach ($details as $key => $value) {

            $rowStyle = $isEvenRow
                ? 'background:#d7d7d7;border-bottom:1px solid #fff'
                : 'background:#fff;border-bottom:1px solid #fff';

            $data = is_array($value) ? implode(', ', $value) : e($value);
            $label = __(e($key));
            $tableRows .= "<tr style='{$rowStyle}'><th>{$label}</th><td>{$data}</td></tr>";

            $isEvenRow = !$isEvenRow;
        }
        return "<table style='width:100%;border:1px solid #ccc'><tbody>{$tableRows}</tbody></table>";
    }
}
