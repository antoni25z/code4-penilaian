<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Department extends Seeder
{
    public function run()
    {
        $department_data = [
			[
				'dept_name'  => 'Keuangan',
			],
			[
				'dept_name' => 'Produksi',
			],
			[
				'dept_name'	=> 'Gudang',
            ],
            [
				'dept_name'	=> 'Akuntan',
            ],
		];

		foreach($department_data as $data){
			$this->db->table('department')->insert($data);
		}
    }
}
