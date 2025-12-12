<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $allowedFields = ['course_name', 'course_code', 'description', 'instructor_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function getCoursesWithInstructor()
    {
        return $this->select('courses.*, users.name as instructor_name')
                    ->join('users', 'users.id = courses.instructor_id', 'left')
                    ->findAll();
    }

    public function getCoursesByInstructor($instructorId)
    {
        return $this->where('instructor_id', $instructorId)
                    ->findAll();
    }

    public function getCourseWithInstructor($courseId)
    {
        return $this->select('courses.*, users.name as instructor_name')
                    ->join('users', 'users.id = courses.instructor_id', 'left')
                    ->where('courses.id', $courseId)
                    ->first();
    }
}
