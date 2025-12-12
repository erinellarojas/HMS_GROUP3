<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateEnrollmentsTable extends Migration
{
    public function up()
    {
        // Define fields for the enrollments table
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
            'course_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'enrollment_date' => [
                'type' => 'DATETIME',
                // Use RawSql to set CURRENT_TIMESTAMP as the default value
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['enrolled', 'completed'],
                'default' => 'enrolled',
            ],
        ]);

        $this->forge->addKey('id', true);
        
        // This unique key ensures a student can only enroll in a course once
        $this->forge->addUniqueKey(['user_id', 'course_id']); 
        
        // Define Foreign Keys
        // Links to the users table
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE'); 
        // Links to the courses table
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE'); 

        $this->forge->createTable('enrollments', true);
    }

    public function down()
    {
        $this->forge->dropTable('enrollments', true);
    }
}