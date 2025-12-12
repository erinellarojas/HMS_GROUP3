<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
        // Automatically redirect root URL to login page
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        
        return redirect()->to('/login');
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (empty($email) || empty($password)) {
            return redirect()->back()->with('error', 'Email and password are required');
        }

        try {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
                // Set session data for automatic login
            session()->set([
                'isLoggedIn' => true,
                'user_id' => $user['id'],
                'user_name' => $user['name'],
                'user_email' => $user['email'],
                'user_role' => $user['role']
            ]);

            $this->logLoginAttempt($email, true);

                // Automatically redirect to dashboard after successful login
            return redirect()->to('/dashboard');
        } else {
            $this->logLoginAttempt($email, false);

            return redirect()->back()->with('error', 'Invalid email or password');
            }
        } catch (\Exception $e) {
            log_message('error', 'Login attempt failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Database connection error. Please contact the administrator.');
        }
    }

    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/register');
    }

    public function attemptRegister()
    {
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $role = 'student';

        if (empty($name) || empty($email) || empty($password)) {
            return redirect()->back()->with('error', 'All fields are required');
        }

        try {
        $userModel = new \App\Models\UserModel();
            $existingUser = $userModel->where('email', $email)->first();
            
            if ($existingUser) {
            return redirect()->back()->with('error', 'Email already exists');
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'role' => $role,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($userModel->insert($data)) {
            $userId = $userModel->getInsertID();
                
                // Automatically log in the user after registration
            session()->set([
                'isLoggedIn' => true,
                'user_id' => $userId,
                'user_name' => $name,
                'user_email' => $email,
                'user_role' => $role
            ]);

                // Automatically redirect to dashboard after successful registration
            return redirect()->to('/dashboard')->with('success', 'Account created successfully! Welcome to your dashboard.');
        } else {
            return redirect()->back()->with('error', 'Failed to create user');
            }
        } catch (\Exception $e) {
            log_message('error', 'Registration failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Database connection error. Please contact the administrator.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please log in to access the dashboard');
        }

        $user_role = session()->get('user_role');
        $user_name = session()->get('user_name');
        $user_id = session()->get('user_id');

        $data = [
            'user_role' => $user_role,
            'user_name' => $user_name,
            'user_id' => $user_id
        ];

        if ($user_role === 'admin') {
            $data = array_merge($data, $this->getAdminData());
        } elseif ($user_role === 'teacher') {
            $data = array_merge($data, $this->getTeacherData());
        } elseif ($user_role === 'student') {
            $data = array_merge($data, $this->getStudentData());
        }

        return view('auth/dashboard', $data);
    }

    public function switchRole($role)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please log in first');
        }

        $validRoles = ['student', 'teacher', 'admin'];
        if (!in_array($role, $validRoles)) {
            return redirect()->to('/dashboard')->with('error', 'Invalid role');
        }

        session()->set('user_role', $role);

        return redirect()->to('/dashboard')->with('success', 'Role switched to ' . ucfirst($role));
    }

    private function getAdminData()
    {
        try {
        $userModel = new \App\Models\UserModel();

            $courseModel = new \App\Models\CourseModel();

        return [
            'total_users' => $userModel->countAll(),
                'total_courses' => $courseModel->countAll(),
            'admin_count' => $userModel->where('role', 'admin')->countAllResults(),
            'teacher_count' => $userModel->where('role', 'teacher')->countAllResults(),
            'student_count' => $userModel->where('role', 'student')->countAllResults(),
            'total_logins_today' => 0,
            'failed_login_attempts' => 0
        ];
        } catch (\Exception $e) {
            log_message('error', 'getAdminData failed: ' . $e->getMessage());
            return [
                'total_users' => 0,
                'total_courses' => 0,
                'admin_count' => 0,
                'teacher_count' => 0,
                'student_count' => 0,
                'total_logins_today' => 0,
                'failed_login_attempts' => 0
            ];
        }
    }

    private function getTeacherData()
    {
        try {
        $user_id = session()->get('user_id');
        $courseModel = new \App\Models\CourseModel();

        return [
                'my_classes' => $courseModel->getCoursesByInstructor($user_id) ?? [],
                'pending_grades' => 0
            ];
        } catch (\Exception $e) {
            log_message('error', 'getTeacherData failed: ' . $e->getMessage());
            return [
                'my_classes' => [],
            'pending_grades' => 0
        ];
        }
    }

    private function getStudentData()
    {
        try {
        $user_id = session()->get('user_id');
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $courseModel = new \App\Models\CourseModel();

            $enrolledCourses = $enrollmentModel->getUserEnrollments($user_id) ?? [];
            
            // Try to get courses with instructor first
            $allCourses = $courseModel->getCoursesWithInstructor() ?? [];
            
            // Fallback: If no courses found with instructor, get all courses without join
            if (empty($allCourses)) {
                $allCourses = $courseModel->findAll() ?? [];
            }

            // Show all courses that user is not enrolled in
            // Filter: Only show courses user hasn't enrolled in yet
        $availableCourses = [];
        foreach ($allCourses as $course) {
                // Check if course has required fields
                if (isset($course['id']) && isset($course['course_name']) && !empty($course['course_name'])) {
                    // Only add if user is not already enrolled
                    if (!$enrollmentModel->isAlreadyEnrolled($user_id, $course['id'])) {
                        // Ensure instructor_name is set (even if null)
                        if (!isset($course['instructor_name'])) {
                            $course['instructor_name'] = null;
                        }
                $availableCourses[] = $course;
                    }
            }
        }

        return [
            'enrolled_courses' => $enrolledCourses,
            'available_courses' => $availableCourses,
            'completed_assignments' => 0,
            'pending_assignments' => 0,
            'gpa' => 'N/A'
        ];
        } catch (\Exception $e) {
            log_message('error', 'getStudentData failed: ' . $e->getMessage());
            return [
                'enrolled_courses' => [],
                'available_courses' => [],
                'completed_assignments' => 0,
                'pending_assignments' => 0,
                'gpa' => 'N/A'
            ];
        }
    }

    private function logLoginAttempt($email, $success)
    {
        // Log login attempts for security monitoring
        $logData = [
            'email' => $email,
            'success' => $success ? 1 : 0,
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        // Log to file
        $logMessage = sprintf(
            'Login attempt - Email: %s, Success: %s, IP: %s, Time: %s',
            $email,
            $success ? 'Yes' : 'No',
            $logData['ip_address'],
            $logData['timestamp']
        );
        
        log_message($success ? 'info' : 'warning', $logMessage);
    }

}
