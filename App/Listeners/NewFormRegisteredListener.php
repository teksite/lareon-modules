<?php

namespace Lareon\Modules\Questionnaire\App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Lareon\Modules\Questionnaire\App\Mail\ReceivedAnnouncementMail;
use Lareon\Modules\Questionnaire\App\Models\Form;
use Lareon\Modules\Questionnaire\App\Models\Inbox;

class NewFormRegisteredListener implements ShouldQueue
{
    private const QUEUE_NAME = 'emails';

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $inbox = $event->inbox;

        $form = $event->form;

        $announcements = $form->announcement;

        $emails = $this->parseCommaSeparated($announcements->emails);

        if (!empty($emails)) $this->sendEmailsToAdmins($emails, $form, $inbox);

        if ($form->response_client) {
            if (isset(($inbox->data->array())['email'])) $this->sendEmailToClient($emails, $form, $inbox);
        }
    }

    /**
     * Parse comma-separated string into array.
     */
    private function parseCommaSeparated(?string $value): array
    {
        return $value ? array_filter(array_map('trim', exploding($value)->toArray())) : [];
    }

    /**
     * Send notification emails.
     */
    private function sendEmailsToAdmins(array $emails, Form $form, Inbox $inbox): void
    {
        $subject = __('new form submitted :title', ['title' => $form->title]);
        $heading = __('hi');
        $introduction = [
            __('a new form has been submitted: :title', ['title' => $form->title]),
            __('please check the inbox and take the necessary actions'),
        ];
        $action = [
            'title' => __('check it'),
            'url' => route('admin.questionnaire.inboxes.edit', $inbox),
        ];
        $explanation = $this->generateEmailTable($inbox->data->toArray());
        $content = [
            'subject' => $subject,
            'heading' => $heading,
            'introduction' => $introduction,
            'action' => $action,
            'explanation' => $explanation,
        ];
        $mail = new ReceivedAnnouncementMail($content);

        $mail->onQueue(self::QUEUE_NAME);

        foreach ($emails as $email) {
            Mail::to($email)->queue($mail);
        }
    }

    private function sendEmailToClient(array $emails, Form $form, Inbox $inbox): void
    {
        $subject = __(config('app.name')) . ' - ' . __('new form is submitted');
        $heading = __('hi');
        $introduction = [
            __('we\'ve received your form submission on :site', ['site' => __(config('app.name'))]),
            __('our team will check your request and get in touch with you if a call is needed'),
        ];
        $explanation = $this->generateEmailTable($inbox->data->toArray());
        $content = [
            'subject' => $subject,
            'heading' => $heading,
            'introduction' => $introduction,
            'explanation' => $explanation,
        ];
        $mail = new ReceivedAnnouncementMail($content);
        $mail->onQueue(self::QUEUE_NAME);
        foreach ($emails as $email) {
            Mail::to($email)->queue($mail);
        }
    }

    /**
     * Generate HTML table for email content.
     */
    private function generateEmailTable(array $details): string
    {
        $tableRows = '';
        $isEvenRow = true;

        foreach ($details as $key => $value) {
            if ($key === 'formpot') continue;

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
