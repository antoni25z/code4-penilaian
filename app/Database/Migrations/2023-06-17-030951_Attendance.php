<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Attendance extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'employee_id'       => [
                'type'           => 'INT',
                'constraint'     => 11
            ],
            'alpha'       => [
                'type'           => 'INT',
                'constraint'     => 2
            ],
            'permit'       => [
                'type'           => 'INT',
                'constraint'     => 2
            ],
            'sick'       => [
                'type'           => 'INT',
                'constraint' => 2
            ],
            'month'       => [
                'type'           => 'INT',
                'constraint' => 2
            ],
            'year'       => [
                'type'           => 'INT',
                'constraint' => 4
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('attendance', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('attendance');
    }
}
