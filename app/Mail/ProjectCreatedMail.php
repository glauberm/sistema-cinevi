<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;

class ProjectCreatedMail extends DefaultMailable
{
    use Queueable;

    public string $title = 'Novo Projeto';

    public string $action = 'Visualizar projeto';

    public readonly string $url;

    public function __construct(public readonly Project $project)
    {
        $this->url = route('project.update', ['id' => $project->id]);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails/project/created--html',
            text: 'emails/project/created--text'
        );
    }
}
