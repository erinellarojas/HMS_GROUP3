<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMaterialsTable extends Migration
{
    public function up()
    {
        // Define fields for the materials table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'course_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'file_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true); // Set id as primary key
        // Define Foreign Key: Links to the courses table
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('materials', true);
    }

    public function down()
    {
        $this->forge->dropTable('materials', true);
    }
}
