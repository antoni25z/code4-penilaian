<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Department extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 111,
                'auto_increment' => true,
			],
			'dept_name'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 255
			],
		]);

		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('department', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('department');
    }
}
