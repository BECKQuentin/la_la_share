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

    public function send(array $data): void
    {
        if($this->appEnv === 'dev') {
            if(!isset($data['subject'])) {
                throw new Exception("You should specify a subject");
            }
            $data['to'] = $this->emailDeveloper;
        }
    }
<<<<<<< HEAD


=======
  
>>>>>>> 1a20878e7e7820192fa1501a31d7df6f6d89141d
}