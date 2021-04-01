<?php

namespace App\Service;

use Exception;

class EmailService
{
    private $mailer;
    private $emailAdmin;
    private $emailDeveloper;
    private $appEnv;
    private $logger;

    public function __construct(
        string $emailAdmin,
        string $emailDeveloper,
        string $appEnv
    )
    {
        
    }

    public function send(array $data): bool
    {
        if($this->appEnv === 'dev') {
            if(!isset($data['subject'])) {
                throw new Exception("You should specify a subject");
            }
            $data['to'] = $this->emailDeveloper;
        }
    }

    $email = (new TemplatedEmail())
        ->from($data['from'] ?? $this->emailAdmin)
        ->to($data['to'] ?? $this->emailAdmin)
        ->replyTo($data['replyTo'] ?? $data['from'] ?? $this->emailAdmin)
        ->subject($data['subject'] ?? 'La-la-share')
        ->htmlTemplate($data['template'])
        ->context($data['context'] ?? [])
}