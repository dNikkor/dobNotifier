<?php
declare(strict_types=1);

use App\Core\DobNotifier;
use PHPUnit\Framework\TestCase;

final class DobNotifierTest extends TestCase
{

    public function testPrepareDobRange(): void
    {
        $data = new DobNotifier('test_data.xml');
        $now = new DateTime (date('Y-m-d'));
        $now->modify('+6 day');
        $date = $data->prepareDobRange($now->format('Y-m-d'));
        $this->assertEquals(
            6,
            $date
        );
    }

    public function testPathException()
    {
        try {
            new DobNotifier('test1_data.xml');
            static::fail();
        } catch (Exception $e) {
            $this->assertEquals(
                $e->getMessage(),
                'invalid path'
            );
        }
    }

    public function testSortUser()
    {
        $user = new class()
        {
        };
        $data = new DobNotifier('test_data.xml');
        $now = new DateTime (date('Y-m-d'));
        $now->modify('+6 day');
        $data->sortUser($now->format('Y-m-d'), $user);
        $users = $data->getSortedUsers();
        $this->assertEquals(
            $users[0],
            $user
        );
    }

}