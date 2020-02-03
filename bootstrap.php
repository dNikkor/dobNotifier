<?php
declare(strict_types=1);

require 'vendor/autoload.php';

use App\Core\DobNotifier;
use App\Core\Mailer;

$users = new DobNotifier('data.xml');
$users->userDataExtractor();
$sortedUsers = $users->getSortedUsers();

$mailer = new Mailer((array)$sortedUsers);
$mailer->run();