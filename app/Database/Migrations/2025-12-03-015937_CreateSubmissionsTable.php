<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateSubmissionsTable extends Migration
{
    public function up()
    {
        // Define fields for the submissions table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'quiz_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'answer' => [ // The student's chosen answer (e.g., 'a', 'b', 'c', or 'd')
                'type' => 'VARCHAR',
                'constraint' => '1',
            ],
            'is_correct' => [ // Flag to easily check if the answer was correct (1) or incorrect (0)
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'submitted_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);
        
        // Define Foreign Keys
        // Links the submission to a specific student
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE'); 
        // Links the submission to a specific quiz question
        $this->forge->addForeignKey('quiz_id', 'quizzes', 'id', 'CASCADE', 'CASCADE'); 

        // You might want to remove the unique key if you allow multiple submissions/attempts per quiz,
        // but for a strict single attempt per question, this key is useful.
        // If allowing multiple attempts, comment out this line:
        // $this->forge->addUniqueKey(['user_id', 'quiz_id']); 

        $this->forge->createTable('submissions', true);
    }

    public function down()
    {
        $this->forge->dropTable('submissions', true);
    }
}