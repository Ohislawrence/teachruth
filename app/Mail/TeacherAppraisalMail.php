<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TeacherAppraisalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $teacherName;
    public $overallScore;
    public $grade;
    public $competencies;
    public $strengths;
    public $improvementAreas;
    public $feedbackSummary;
    public $dashboardUrl;
    public $platformUrl;
    public $helpUrl;
    public $privacyUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->teacherName = $data['teacher_name'];
        $this->overallScore = $data['overall_score'];
        $this->grade = $data['grade'];
        $this->competencies = $data['competencies'];
        $this->strengths = $data['strengths'];
        $this->improvementAreas = $data['improvement_areas'];
        $this->feedbackSummary = $data['feedback_summary'];
        $this->dashboardUrl = $data['dashboard_url'];
        $this->platformUrl = config('app.url');
        $this->helpUrl = config('app.url') . '/help';
        $this->privacyUrl = config('app.url') . '/privacy';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Teacher Appraisal is Ready!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.teacher-appraisal',
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
