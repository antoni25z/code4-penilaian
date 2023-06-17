<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Criteria extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'name'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 255
            ],
            'type'       => [
                'type'           => 'INT',
                'constraint'     => 11
            ],
            'target'       => [
                'type'           => 'INT',
                'constraint'     => 11
            ],
            'aspect_id'       => [
                'type'           => 'INT',
                'constraint'     => 11
            ],
            'dept_id'       => [
                'type'           => 'INT',
                'constraint'     => 11
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('criteria', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('criteria');
    }
}
