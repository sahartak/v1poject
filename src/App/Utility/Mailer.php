<?php

namespace App\Utility;

class Mailer {
    
    protected $mailer;
    
    public function __construct(\DBConnection $db) {
        $settings = new \App\Model\Settings($db, 'mail_settings');
        $settings = $settings->getAll();
        
        $mt = $settings['mail_transport'];
        
        $transport = \Swift_SmtpTransport::newInstance($settings['mail_' . $mt . '_host'], $settings['mail_' . $mt . '_port'])
            ->setUsername($settings['mail_' . $mt . '_user'])
            ->setPassword($settings['mail_' . $mt . '_password']);
        
        $this->mailer = \Swift_Mailer::newInstance($transport);
    }
    
    public function send(\Swift_Message $message) {
        return $this->mailer->send($message);
    }
}