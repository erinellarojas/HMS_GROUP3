<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // ADMIN User
            [
                'name' => 'Admin User',
                'email' => 'admin@test.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            // TEACHER User
            [
                'name' => 'Teacher Lee',
                'email' => 'teacher@test.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'teacher',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            // STUDENT User (Default role)
            [
                'name' => 'Student Juan',
                'email' => 'student@test.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];

        // Inserting data into the 'users' table
        $this->db->table('users')->insertBatch($data);
    }
}