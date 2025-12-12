<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table = 'enrollments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'course_id', 'enrollment_date'];
    protected $useTimestamps = false;

    public function enrollUser($data)
    {
        return $this->insert($data);
    }

    public function getUserEnrollments($user_id)
    {
        return $this->select('enrollments.*, enrollments.course_id, enrollments.enrollment_date as enrolled_at, courses.course_name, courses.description, courses.course_code, courses.id, users.name as instructor_name')
                    ->join('courses', 'courses.id = enrollments.course_id', 'left')
                    ->join('users', 'users.id = courses.instructor_id', 'left')
                    ->where('enrollments.user_id', $user_id)
                    ->findAll();
    }

    public function isAlreadyEnrolled($user_id, $course_id)
    {
        return $this->where('user_id', $user_id)
                    ->where('course_id', $course_id)
                    ->first() !== null;
    }
}
