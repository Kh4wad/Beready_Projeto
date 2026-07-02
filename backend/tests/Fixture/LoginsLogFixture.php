<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class LoginsLogFixture extends TestFixture
{
    public string $table = 'logins_log';
    
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'login_time' => date('Y-m-d H:i:s'),
                'ip_address' => '192.168.1.1',
                'success' => true,
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'login_time' => date('Y-m-d H:i:s'),
                'ip_address' => '192.168.1.2',
                'success' => false,
            ],
        ];
        parent::init();
    }
}