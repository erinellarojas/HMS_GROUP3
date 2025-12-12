<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuizzesTable extends Migration
{
    public function up()
    {
        // Define fields for the quizzes table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'lesson_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'question_text' => [
                'type' => 'TEXT',
            ],
            'option_a' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'option_b' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'option_c' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'option_d' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'correct_answer' => [ // Store the correct option label (e.g., 'a', 'b', 'c', or 'd')
                'type' => 'VARCHAR',
                'constraint' => '1',
            ],
            'points' => [
                'type' => 'INT',
                'constraint' => 3,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('lesson_id', 'lessons', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('quizzes', true);
    }

    public function down()
    {
        $this->forge->dropTable('quizzes', true);
    }
}