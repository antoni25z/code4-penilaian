<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Aspect extends Seeder
{
    public function run()
    {
        $aspect_data = [
            [
                'name' => 'PERILAKU',
                'core_weight' => 55,
                'secondary_weight' => 45,
                'weight'  => 40,
            ],
            [
                'name' => 'KECERDASAN',
                'core_weight' => 60,
                'secondary_weight' => 40,
                'weight'  => 30,
            ],
            [
                'name' => 'KEAHLIAN',
                'core_weight' => 65,
                'secondary_weight' => 35,
                'weight'  => 30,
            ],
        ];

        foreach($aspect_data as $data) {
            $this->db->table('aspect')->insert($data);
        }
    }
}
