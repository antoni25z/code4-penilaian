<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 111,
			],
            'username'    => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
			'email' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255
			],
            'password' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255
			],
            'address' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255
			],
            'type' => [
				'type'           => 'INT',
				'constraint'     => 1
			],
            'fname'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 255
			],
			'lname'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
            'birth_date'      => [
				'type'           => 'DATE',
			],
            'birth_place'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
            'sex'      => [
				'type'           => 'CHAR',
				'constraint'     => 1,
			],
            'dept_id'      => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
		]);

		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('user', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
