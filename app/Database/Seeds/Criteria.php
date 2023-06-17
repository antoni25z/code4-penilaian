<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Criteria extends Seeder
{
    public function run()
    {
        $criteria_data = [
            [
                'name' => 'Kedisiplinan',
                'type' => 0,
                'target' => 5,
                'aspect_id' => 1,
                'dept_id' => 0
            ],
            [
                'name' => 'Sikap',
                'type' => 0,
                'target' => 5,
                'aspect_id' => 1,
                'dept_id' => 0
            ],
            [
                'name' => 'Kepercayaan Diri',
                'type' => 0,
                'target' => 5,
                'aspect_id' => 1,
                'dept_id' => 0
            ],
            [
                'name' => 'Gigih',
                'type' => 0,
                'target' => 5,
                'aspect_id' => 1,
                'dept_id' => 0
            ],
            [
                'name' => 'Kemampuan Beradaptasi',
                'type' => 0,
                'target' => 5,
                'aspect_id' => 1,
                'dept_id' => 0
            ],
            [
                'name' => 'Kemampuan Leadership',
                'type' => 0,
                'target' => 5,
                'aspect_id' => 2,
                'dept_id' => 0
            ],
            [
                'name' => 'Kemampuan Manajemen',
                'type' => 0,
                'target' => 5,
                'aspect_id' => 2,
                'dept_id' => 0
            ],
            [
                'name' => 'Kemampuan Analisis Tinggi',
                'type' => 0,
                'target' => 5,
                'aspect_id' => 2,
                'dept_id' => 0
            ],
            [
                'name' => 'Kemampuan Logika',
                'type' => 0,
                'target' => 5,
                'aspect_id' => 2,
                'dept_id' => 0
            ],
            [
                'name' => 'Berpikir Sistematis',
                'type' => 0,
                'target' => 5,
                'aspect_id' => 2,
                'dept_id' => 0
            ],
            [
                'name' => 'Microsoft Excel',
                'type' => 0,
                'target' => 5,
                'aspect_id' => 3,
                'dept_id' => 0
            ],
            [
                'name' => 'Kemampuan Berhitung',
                'type' => 0,
                'target' => 5,
                'aspect_id' => 3,
                'dept_id' => 0
            ],
            [
                'name' => 'Menguasai Software Akuntansi',
                'type' => 0,
                'target' => 5,
                'aspect_id' => 3,
                'dept_id' => 0
            ],
            [
                'name' => 'Bahasa Inggris',
                'type' => 0,
                'target' => 5,
                'aspect_id' => 3,
                'dept_id' => 0
            ],
        ];

        foreach($criteria_data as $data) {
            $this->db->table('criteria')->insert($data);
        }
    }
}
