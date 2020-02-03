<?php
declare(strict_types=1);

namespace App\Core;

interface DeliveryInterface
{
    public function getTitle(string $name);

    public function getMessageText(string $name);

    public function sendMessage(string $email, string $title, string $message);
}