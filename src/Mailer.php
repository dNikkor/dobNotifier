<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Class Mailer
 * @package App\Core
 */
class Mailer implements DeliveryInterface
{
    /**
     * @var array
     */
    private $users;

    /**
     * Mailer constructor.
     * @param array $users
     */
    public function __construct(array $users)
    {
        $this->users = $users;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        foreach ($this->users as $user) {
            $emailTitle = $this->getTitle((string)$user->Name);
            $emailBody = $this->getMessageText((string)$user->Name);
            $this->sendMessage((string)$user->Email, $emailTitle, $emailBody);
        }
    }

    /**
     * @param string $name
     * @return string
     */
    public function getTitle(string $name): string
    {
        $title = 'Happy birthday %name%';
        $title = str_replace('%name%', $name, $title);
        return $title;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getMessageText(string $name): string
    {
        $body = 'Happy birthday dear %name%, have fun with your personal discounts';
        $body = str_replace('%name%', $name, $body);
        return $body;
    }

    /**
     * @param string $email
     * @param string $title
     * @param string $body
     */
    public function sendMessage(string $email, string $title, string $body): void
    {
        //TODO php mail() function realisation or PHPMailer class [https://github.com/PHPMailer/PHPMailer]
        print_r("Email to: *{$email}* with title *{$title}* and message *{$body}* has been delivered successfully. \n");
    }
}