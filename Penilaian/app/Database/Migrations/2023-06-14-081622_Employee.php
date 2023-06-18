<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Employee extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 111,
			],
			'fname'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 255
			],
			'lname'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			'email' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255
			],
			'sex'      => [
				'type'           => 'CHAR',
				'constraint'     => 1,
			],
            'birth_place'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
            'birth_date'      => [
				'type'           => 'DATE',
			],
            'join_date'      => [
				'type'           => 'DATE',
			],
			
            'dept_id'      => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
            'address'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
            'promoted'      => [
				'type'           => 'INT',
				'constraint'     => 1,
			],
		]);

		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('employee', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('employee');
    }
}
