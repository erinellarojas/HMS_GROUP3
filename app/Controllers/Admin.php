<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        helper(['form', 'url']);
    }

    private function checkAccess()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }

        if ($this->session->get('user_role') !== 'admin') {
            return redirect()->to(site_url('dashboard'))->with('error', 'Access denied. Admin access only.');
        }

        return true;
    }

    public function index()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $data = [
            'user_name' => $this->session->get('user_name'),
            'user_role' => $this->session->get('user_role'),
        ];

        return view('admin/index', $data);
    }

    public function users()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $data['user_name'] = $this->session->get('user_name');
        $data['user_role'] = $this->session->get('user_role');

        $userModel = new \App\Models\UserModel();
        $data['users'] = $userModel->findAll();

        return view('admin/users', $data);
    }

    public function courses()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $data['user_name'] = $this->session->get('user_name');
        $data['user_role'] = $this->session->get('user_role');

        $courseModel = new \App\Models\CourseModel();
        $data['courses'] = $courseModel->getCoursesWithInstructor();

        return view('admin/courses', $data);
    }

    public function reports()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $data['user_name'] = $this->session->get('user_name');
        $data['user_role'] = $this->session->get('user_role');

        // Sample reports data
        $data['reports'] = [
            [
                'title' => 'User Registration Trends',
                'description' => 'Monthly user registration statistics',
                'last_updated' => '2024-01-15'
            ],
            [
                'title' => 'Course Enrollment Report',
                'description' => 'Enrollment numbers per course',
                'last_updated' => '2024-01-14'
            ],
            [
                'title' => 'System Performance Metrics',
                'description' => 'Server performance and uptime statistics',
                'last_updated' => '2024-01-13'
            ]
        ];

        return view('admin/reports', $data);
    }

    public function settings()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $data['user_name'] = $this->session->get('user_name');
        $data['user_role'] = $this->session->get('user_role');

        return view('admin/settings', $data);
    }

    public function createUser()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $data['user_name'] = $this->session->get('user_name');
        $data['user_role'] = $this->session->get('user_role');

        return view('admin/create_user', $data);
    }

    public function storeUser()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $rules = [
            'name' => 'required|min_length[3]|alpha_space',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role' => 'required|in_list[student,teacher,admin]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new \App\Models\UserModel();
        $userData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if (!$userModel->insert($userData)) {
            return redirect()->back()->withInput()->with('error', 'Failed to create user');
        }

        return redirect()->to(site_url('admin/users'))->with('success', 'User created successfully');
    }

    public function userManagement()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $data['user_name'] = $this->session->get('user_name');
        $data['user_role'] = $this->session->get('user_role');

        $userModel = new \App\Models\UserModel();
        $data['users'] = $userModel->findAll();

        return view('admin/user_management', $data);
    }

    public function viewUser($userId)
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to(site_url('admin/users'))->with('error', 'User not found');
        }

        // Prevent viewing admin users
        if ($user['role'] === 'admin') {
            return redirect()->to(site_url('admin/users'))->with('error', 'Cannot view admin user details');
        }

        $data = [
            'user_name' => $this->session->get('user_name'),
            'user_role' => $this->session->get('user_role'),
            'user' => $user
        ];

        return view('admin/view_user', $data);
    }

    public function editUser($userId)
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to(site_url('admin/users'))->with('error', 'User not found');
        }

        $data = [
            'user_name' => $this->session->get('user_name'),
            'user_role' => $this->session->get('user_role'),
            'user' => $user
        ];

        return view('admin/edit_user', $data);
    }

    public function updateUser($userId)
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $rules = [
            'name' => 'required|min_length[3]|alpha_space',
            'email' => 'required|valid_email',
            'role' => 'required|in_list[student,teacher,admin]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to(site_url('admin/users'))->with('error', 'User not found');
        }

        // Check if email is being changed and if it's unique
        $newEmail = $this->request->getPost('email');
        if ($newEmail !== $user['email']) {
            $existingUser = $userModel->where('email', $newEmail)->first();
            if ($existingUser) {
                return redirect()->back()->withInput()->with('error', 'Email already exists');
            }
        }

        $updateData = [
            'name' => $this->request->getPost('name'),
            'email' => $newEmail,
            'role' => $this->request->getPost('role'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Only update password if provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $userModel->update($userId, $updateData);

        return redirect()->to(site_url('admin/users'))->with('success', 'User updated successfully');
    }

    public function deleteUser($userId)
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to(site_url('admin/users'))->with('error', 'User not found');
        }

        // Prevent admin from deleting themselves
        if ($userId == $this->session->get('user_id')) {
            return redirect()->to(site_url('admin/users'))->with('error', 'You cannot delete your own account');
        }

        $userModel->delete($userId);

        return redirect()->to(site_url('admin/users'))->with('success', 'User deleted successfully');
    }

    public function viewCourse($courseId)
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $courseModel = new \App\Models\CourseModel();
        $materialModel = new \App\Models\MaterialModel();
        
        $course = $courseModel->getCourseWithInstructor($courseId);

        if (!$course) {
            return redirect()->to(site_url('admin/courses'))->with('error', 'Course not found');
        }

        // Get materials for this course
        $materials = $materialModel->getMaterialsByCourse($courseId);

        $data = [
            'user_name' => $this->session->get('user_name'),
            'user_role' => $this->session->get('user_role'),
            'course' => $course,
            'materials' => $materials
        ];

        return view('admin/view_course', $data);
    }

    public function editCourse($courseId)
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $courseModel = new \App\Models\CourseModel();
        $userModel = new \App\Models\UserModel();

        $course = $courseModel->find($courseId);
        if (!$course) {
            return redirect()->to(site_url('admin/courses'))->with('error', 'Course not found');
        }

        $data = [
            'user_name' => $this->session->get('user_name'),
            'user_role' => $this->session->get('user_role'),
            'course' => $course,
            'teachers' => $userModel->where('role', 'teacher')->findAll()
        ];

        return view('admin/edit_course', $data);
    }

    public function updateCourse($courseId)
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $courseModel = new \App\Models\CourseModel();
        $course = $courseModel->find($courseId);

        if (!$course) {
            return redirect()->to(site_url('admin/courses'))->with('error', 'Course not found');
        }

        $newCourseName = $this->request->getPost('course_name');
        $newCourseCode = $this->request->getPost('course_code');
        
        // Build validation rules - allow current values but prevent duplicates
        $rules = [
            'course_name' => 'required|min_length[3]',
            'course_code' => 'required|min_length[2]',
            'description' => 'required',
            'instructor_id' => 'required|numeric'
        ];
        
        // Check if course name is being changed and if it's unique
        if ($newCourseName !== $course['course_name']) {
            $rules['course_name'] .= '|is_unique[courses.course_name]';
        }
        
        // Check if course code is being changed and if it's unique
        if ($newCourseCode !== $course['course_code']) {
            $rules['course_code'] .= '|is_unique[courses.course_code]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Additional duplicate check (defense in depth)
        if ($newCourseName !== $course['course_name']) {
            $existingCourse = $courseModel->where('course_name', $newCourseName)
                                         ->where('id !=', $courseId)
                                         ->first();
            if ($existingCourse) {
                return redirect()->back()->withInput()->with('error', 'A course with this name already exists.');
            }
        }
        
        if ($newCourseCode !== $course['course_code']) {
            $existingCourse = $courseModel->where('course_code', $newCourseCode)
                                         ->where('id !=', $courseId)
                                         ->first();
            if ($existingCourse) {
                return redirect()->back()->withInput()->with('error', 'A course with this code already exists.');
            }
        }

        $updateData = [
            'course_name' => $newCourseName,
            'course_code' => $newCourseCode,
            'description' => $this->request->getPost('description'),
            'instructor_id' => $this->request->getPost('instructor_id'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $courseModel->update($courseId, $updateData);

        return redirect()->to(site_url('admin/courses'))->with('success', 'Course updated successfully');
    }

    public function deleteCourse($courseId)
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $courseModel = new \App\Models\CourseModel();
        $course = $courseModel->find($courseId);

        if (!$course) {
            return redirect()->to(site_url('admin/courses'))->with('error', 'Course not found');
        }

        $courseModel->delete($courseId);

        return redirect()->to(site_url('admin/courses'))->with('success', 'Course deleted successfully');
    }

    public function createCourse()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $userModel = new \App\Models\UserModel();

        $data = [
            'user_name' => $this->session->get('user_name'),
            'user_role' => $this->session->get('user_role'),
            'teachers' => $userModel->where('role', 'teacher')->findAll()
        ];

        return view('admin/create_course', $data);
    }

    public function storeCourse()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $rules = [
            'course_name' => 'required|min_length[3]|is_unique[courses.course_name]',
            'course_code' => 'required|min_length[2]|is_unique[courses.course_code]',
            'description' => 'required',
            'instructor_id' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $courseModel = new \App\Models\CourseModel();
        
        // Additional duplicate check (defense in depth)
        $courseName = $this->request->getPost('course_name');
        $courseCode = $this->request->getPost('course_code');
        
        if ($courseModel->where('course_name', $courseName)->first()) {
            return redirect()->back()->withInput()->with('error', 'A course with this name already exists.');
        }
        
        if ($courseModel->where('course_code', $courseCode)->first()) {
            return redirect()->back()->withInput()->with('error', 'A course with this code already exists.');
        }
        
        $courseData = [
            'course_name' => $courseName,
            'course_code' => $courseCode,
            'description' => $this->request->getPost('description'),
            'instructor_id' => $this->request->getPost('instructor_id'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $courseModel->insert($courseData);

        return redirect()->to(site_url('admin/courses'))->with('success', 'Course created successfully');
    }
}
