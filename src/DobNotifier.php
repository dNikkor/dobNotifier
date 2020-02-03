<?php
declare(strict_types=1);

namespace App\Core;

use Exception;
use SimpleXMLElement;

/**
 * Class DobNotifier
 * @package App\DobNotifier
 */
class DobNotifier
{
    public $sortedUsers;
    private $userData;

    /**
     * DobNotifier constructor.
     * @param string $path
     * @throws Exception
     */
    public function __construct(string $path)
    {
        $this->userData = simplexml_load_file($path, 'SimpleXMLElement', LIBXML_NOWARNING);
        if (!$this->userData) {
            throw new Exception('invalid path');
        }
    }

    /**
     * @return array
     */
    public function getSortedUsers(): array
    {
        return $this->sortedUsers;
    }

    public function userDataExtractor(): void
    {
        foreach ($this->userData->Users->User as $user) {
            foreach ($user->ImportantDates->date as $date) {
                $type = (string)$date->attributes()->type;
                if ($type === 'birthDayDate') {
                    $this->sortUser((string)$date, $user);
                }
            }
        }
    }

    /**
     * @param string $dob
     * @var SimpleXMLElement $user
     */
    public function sortUser(string $dob, $user): void
    {
        $rangeResult = $this->prepareDobRange((string)$dob);
        if ($rangeResult >= 0 && $rangeResult <= 30) {
            $this->sortedUsers[] = $user;
        }
    }

    /**
     * @param string $dob
     * @return int
     */
    public function prepareDobRange(string $dob): int
    {
        $stringDate = preg_replace('/([\d]{4})/', date('Y'), $dob);
        $userBod = date_create($stringDate);
        $currentStamp = date_create(date('Y-m-d'));
        $int = date_diff($currentStamp, $userBod);
        return (int)$int->format('%R%a');
    }

}