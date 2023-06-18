<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Adminaccount extends Seeder
{
    public function run()
    {
        $this->db->table('user')->insert(
            [
                'id' => 1,
                'username' => 'admin',
                'password' => 'admin123',
                'type' => 1
            ]
        );
    }
}
