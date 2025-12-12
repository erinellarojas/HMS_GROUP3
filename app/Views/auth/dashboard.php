<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title>ITE311-BUHISAN Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', 'Inter', sans-serif;
            background: #ffffff;
            min-height: 100vh;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .gradient-bg {
            background: #ffffff;
        }
        .school-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }
        .school-card:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.15), 0 4px 6px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        .academic-blue {
            color: #1e40af;
        }
        .academic-border {
            border-left: 4px solid #2563eb;
        }
        .academic-button {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .academic-button:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }
        .alert-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: none;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            border-left: 4px solid #047857;
        }
        .alert-error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: none;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            border-left: 4px solid #b91c1c;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin {
            animation: spin 1s linear infinite;
        }
        .enroll-btn:not(:disabled) {
            cursor: pointer !important;
        }
        .enroll-btn:not(:disabled):hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .enroll-btn:not(:disabled):active {
            transform: translateY(0);
        }
        /* Table styling for Available Courses */
        table {
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        table thead th {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.75rem;
        }
        table tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }
        table tbody tr:last-child {
            border-bottom: none;
        }
        table tbody tr:hover {
            background: #f9fafb;
        }
    </style>
</head>
<body class="gradient-bg">

    <?= view('templates/header') ?>

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <!-- Main container adjusted to max-w-7xl for wider view -->
        <div class="max-w-7xl w-full">
            
            <!-- START: NAVIGATION BLOCK -->
            <div class="w-full text-center max-w-xl mx-auto md:max-w-6xl">
                
                <!-- BACK TO HOME LINK -->
                <div class="w-full text-left mb-6">
                    <a href="<?= site_url('dashboard') ?>" class="text-gray-700 hover:text-gray-900 transition duration-200 inline-flex items-center text-lg">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Dashboard Home
                    </a>
                </div>
            </div>
            <!-- END: NAVIGATION BLOCK -->

            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-blue-100 rounded-full mb-6 shadow-lg">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-3">
                    Welcome back, <span class="text-blue-600"><?= esc(ucfirst($user_role)) ?></span>
                </h1>
                <p class="text-lg text-gray-600 mb-6">
                    You are logged in as <span class="font-semibold text-white bg-blue-600 px-4 py-1.5 rounded-full text-sm uppercase tracking-wide shadow-md"><?= esc($user_role) ?></span>
                </p>
                <div id="enrollment-status" class="max-w-xl mx-auto alert-success" role="alert"></div>
            </div>

            <!-- START: CONDITIONAL DASHBOARD CONTENT -->

            <?php if ($user_role === 'student'): ?>
                <!-- STUDENT DASHBOARD BOX (Main Container for Student) -->
                <div class="glass-card rounded-2xl p-8 md:p-10 lg:p-12 mx-auto shadow-2xl max-w-7xl">
                    <div class="mb-6 pb-5 border-b-2 border-gray-200">
                        <h2 class="text-2xl md:text-3xl font-bold mb-2 academic-blue flex items-center">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3 md:mr-4">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        Student Learning Portal
                    </h2>
                        <p class="text-gray-600 text-sm md:text-base ml-13 md:ml-16">Manage your courses, assignments, and academic progress</p>
                    </div>

                    <!-- Main Student Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 md:gap-6 mb-6">
                        <!-- My Enrolled Courses Section -->
                        <div class="school-card p-5 md:p-6 min-h-[400px] flex flex-col">
                            <h3 class="text-lg md:text-xl font-bold mb-4 academic-blue flex items-center pb-3 border-b-2 border-gray-200">
                                <div class="w-7 h-7 md:w-8 md:h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 md:w-5 md:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                My Enrolled Courses
                            </h3>
                            <div id="enrolled-courses-list" class="space-y-3 flex-1 overflow-y-auto max-h-[450px]">
                                <?php if (empty($enrolled_courses)): ?>
                                    <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p class="text-gray-500 font-medium">You are not currently enrolled in any courses.</p>
                                        <p class="text-gray-400 text-sm mt-2">Browse available courses below to get started.</p>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($enrolled_courses as $course): ?>
                                        <div class="flex justify-between items-center p-3 md:p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg academic-border hover:shadow-md transition duration-200 border border-gray-200" id="enrolled-course-<?= esc($course['course_id']) ?>">
                                            <div class="flex-1 min-w-0">
                                                <p class="font-bold text-base md:text-lg text-gray-800 mb-1 truncate"><?= esc($course['course_name']) ?></p>
                                                <p class="text-xs md:text-sm text-gray-600 mb-2">Enrolled on: <?= esc(date('M d, Y', strtotime($course['enrolled_at']))) ?></p>
                                                <div class="flex items-center gap-2 md:gap-3 flex-wrap">
                                                    <span class="text-xs font-bold px-2 md:px-3 py-1 bg-green-100 text-green-800 rounded-full border border-green-200 whitespace-nowrap">ENROLLED</span>
                                                    <a href="<?= site_url('student/course/' . $course['course_id']) ?>" class="text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline whitespace-nowrap">View Details →</a>
                                                </div>
                                            </div>
                                            <div class="ml-3 md:ml-4 flex-shrink-0">
                                                <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Available Courses Section -->
                        <div class="school-card p-5 md:p-6 min-h-[400px] flex flex-col">
                            <h3 class="text-lg md:text-xl font-bold mb-4 academic-blue flex items-center pb-3 border-b-2 border-gray-200">
                                <div class="w-7 h-7 md:w-8 md:h-8 bg-amber-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 md:w-5 md:h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                Available Courses
                            </h3>
                            
                                <?php if (empty($available_courses)): ?>
                                <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-gray-500 font-medium">No new courses are currently available for enrollment.</p>
                                    <p class="text-gray-400 text-sm mt-2">Check back later for new course offerings.</p>
                                    </div>
                                <?php else: ?>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                                <th class="py-3 px-4 font-bold text-gray-700 text-base">Course Name</th>
                                                <th class="py-3 px-4 font-bold text-gray-700 text-base text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="available-courses-table-body" class="bg-white">
                                    <?php foreach ($available_courses as $course): ?>
                                                <tr class="border-b border-gray-200 hover:bg-blue-50 transition duration-150" id="course-row-<?= esc($course['id']) ?>">
                                                    <td class="py-4 px-4">
                                                        <p class="font-semibold text-gray-800 text-base"><?= esc($course['course_name']) ?></p>
                                                    </td>
                                                    <td class="py-4 px-4 text-center">
                                            <button
                                                            type="button"
                                                            class="enroll-btn academic-button font-semibold py-2.5 px-6 rounded-lg transition-all duration-200 text-sm shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:transform-none disabled:hover:shadow-md"
                                                data-course-id="<?= esc($course['id']) ?>"
                                                data-course-name="<?= esc($course['course_name']) ?>"
                                                id="enroll-btn-<?= esc($course['id']) ?>"
                                                            aria-label="Enroll in <?= esc($course['course_name']) ?>"
                                                <?php if (in_array($course['id'], array_column($enrolled_courses, 'course_id'))): ?>
                                                    disabled
                                                                style="background: #9ca3af; color: #f3f4f6; cursor: not-allowed;"
                                                <?php endif; ?>
                                                            title="<?= in_array($course['id'], array_column($enrolled_courses, 'course_id')) ? 'Already enrolled' : 'Click to enroll in this course' ?>"
                                            >
                                                <?php if (in_array($course['id'], array_column($enrolled_courses, 'course_id'))): ?>
                                                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Enrolled
                                                <?php else: ?>
                                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                                                Enroll
                                                <?php endif; ?>
                                            </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                        </div>
                                <?php endif; ?>
                        </div>
                    </div>

                    <!-- Quick Access Section for Students -->
                    <div class="mt-6 pt-5 border-t-2 border-gray-200">
                        <h3 class="text-lg md:text-xl font-bold mb-4 academic-blue flex items-center">
                            <div class="w-7 h-7 md:w-8 md:h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            Quick Access
                        </h3>
                        <div class="flex justify-center">
                            <a href="<?= site_url('student/courses') ?>" class="school-card flex items-center justify-center p-4 md:p-5 hover:border-blue-300 border-2 border-gray-200 transition duration-200 group min-h-[80px] max-w-md w-full">
                                <div class="w-9 h-9 md:w-10 md:h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition">
                                    <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <span class="font-bold text-sm md:text-base text-gray-700 group-hover:text-blue-600 transition">My Courses</span>
                            </a>
                        </div>
                    </div>
                </div>

            <?php elseif ($user_role === 'teacher'): ?>
                <!-- TEACHER DASHBOARD BOX (Wider size) -->
                <div class="glass-card rounded-2xl p-6 md:p-8 lg:p-10 max-w-6xl mx-auto shadow-2xl">
                    <div class="mb-6 pb-5 border-b-2 border-gray-200">
                        <h2 class="text-2xl md:text-3xl font-bold mb-2 text-amber-600 flex items-center">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-amber-100 rounded-xl flex items-center justify-center mr-3 md:mr-4">
                                <svg class="w-7 h-7 md:w-8 md:h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2m0 2H7m4-9H7m4 0a5 5 0 0110 0v-2a5 5 0 00-10 0v2zm0 0h3"></path></svg>
                            </div>
                        Teacher Management Panel
                    </h2>
                        <p class="text-gray-600 text-sm md:text-base ml-15 md:ml-18">Manage your classes, assignments, and student grades</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                        <a href="<?= site_url('teacher/courses') ?>" class="school-card p-6 md:p-8 text-center border-2 border-gray-200 hover:border-amber-300 transition duration-200 group min-h-[200px] flex flex-col justify-center">
                            <div class="w-14 h-14 md:w-16 md:h-16 bg-amber-100 rounded-xl flex items-center justify-center mx-auto mb-3 md:mb-4 group-hover:bg-amber-200 transition">
                                <svg class="w-7 h-7 md:w-8 md:h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h3 class="font-bold text-base md:text-lg text-gray-800 mb-2 group-hover:text-amber-600 transition">My Classes</h3>
                            <p class="text-xs md:text-sm text-gray-600">View and manage your assigned courses</p>
                        </a>
                        <a href="<?= site_url('teacher/assignments') ?>" class="school-card p-6 md:p-8 text-center border-2 border-gray-200 hover:border-amber-300 transition duration-200 group min-h-[200px] flex flex-col justify-center">
                            <div class="w-14 h-14 md:w-16 md:h-16 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3 md:mb-4 group-hover:bg-blue-200 transition">
                                <svg class="w-7 h-7 md:w-8 md:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="font-bold text-base md:text-lg text-gray-800 mb-2 group-hover:text-blue-600 transition">View Assignments</h3>
                            <p class="text-xs md:text-sm text-gray-600">Review and grade student submissions</p>
                        </a>
                        <a href="<?= site_url('teacher/grades') ?>" class="school-card p-6 md:p-8 text-center border-2 border-gray-200 hover:border-amber-300 transition duration-200 group min-h-[200px] flex flex-col justify-center">
                            <div class="w-14 h-14 md:w-16 md:h-16 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-3 md:mb-4 group-hover:bg-green-200 transition">
                                <svg class="w-7 h-7 md:w-8 md:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                            </div>
                            <h3 class="font-bold text-base md:text-lg text-gray-800 mb-2 group-hover:text-green-600 transition">Manage Grades</h3>
                            <p class="text-xs md:text-sm text-gray-600">Update and track student performance</p>
                        </a>
                    </div>
                </div>

            <?php elseif ($user_role === 'admin'): ?>
                <!-- ADMIN DASHBOARD BOX (Wider size) -->
                <div class="glass-card rounded-2xl p-6 md:p-8 lg:p-10 max-w-6xl mx-auto shadow-2xl">
                    <div class="mb-6 pb-5 border-b-2 border-gray-200">
                        <h2 class="text-2xl md:text-3xl font-bold mb-2 text-red-600 flex items-center">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-red-100 rounded-xl flex items-center justify-center mr-3 md:mr-4">
                                <svg class="w-7 h-7 md:w-8 md:h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.001 12.001 0 002.944 12c.045 2.825 1.258 5.372 3.208 7.218 2.055 1.94 4.793 3.328 7.575 3.844 2.782-.516 5.52-1.904 7.575-3.844 1.95-1.846 3.163-4.393 3.208-7.218a12.001 12.001 0 00-2.432-7.854z"></path></svg>
                            </div>
                        Administrator Control Center
                    </h2>
                        <p class="text-gray-600 text-sm md:text-base ml-15 md:ml-18">System-wide access to manage users, courses, and system settings</p>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-5">
                        <a href="<?= site_url('admin/users') ?>" class="school-card p-5 md:p-6 text-center border-2 border-gray-200 hover:border-red-300 transition duration-200 group min-h-[160px] flex flex-col justify-center">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-red-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-red-200 transition">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <h3 class="font-bold text-sm md:text-base text-gray-800 mb-1 group-hover:text-red-600 transition">Manage Users</h3>
                            <p class="text-xs text-gray-600">User accounts</p>
                        </a>
                        <a href="<?= site_url('admin/courses') ?>" class="school-card p-5 md:p-6 text-center border-2 border-gray-200 hover:border-red-300 transition duration-200 group min-h-[160px] flex flex-col justify-center">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-200 transition">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h3 class="font-bold text-sm md:text-base text-gray-800 mb-1 group-hover:text-blue-600 transition">System Courses</h3>
                            <p class="text-xs text-gray-600">Course management</p>
                        </a>
                        <a href="<?= site_url('admin/reports') ?>" class="school-card p-5 md:p-6 text-center border-2 border-gray-200 hover:border-red-300 transition duration-200 group min-h-[160px] flex flex-col justify-center">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-indigo-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-indigo-200 transition">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <h3 class="font-bold text-sm md:text-base text-gray-800 mb-1 group-hover:text-indigo-600 transition">System Reports</h3>
                            <p class="text-xs text-gray-600">Analytics & data</p>
                        </a>
                        <a href="<?= site_url('admin/settings') ?>" class="school-card p-5 md:p-6 text-center border-2 border-gray-200 hover:border-red-300 transition duration-200 group min-h-[160px] flex flex-col justify-center">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-gray-200 transition">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <h3 class="font-bold text-sm md:text-base text-gray-800 mb-1 group-hover:text-gray-600 transition">Settings</h3>
                            <p class="text-xs text-gray-600">System config</p>
                        </a>
                    </div>
                </div>

            <?php else: ?>
                <!-- FALLBACK / UNDEFINED ROLE -->
                <div class="text-center text-white/80 p-10 glass-card rounded-2xl border-l-8 border-gray-400 max-w-xl mx-auto">
                    <p class="text-2xl font-bold">Access Denied</p>
                    <p class="text-lg mt-2">Your user role is undefined or invalid. Please contact the Administrator.</p>
                </div>
            <?php endif; ?>

            <!-- END: CONDITIONAL DASHBOARD CONTENT -->
            
            </div>
    </div>

    <script>
    // jQuery AJAX for Enrollment
    $(document).ready(function() {
        const enrollmentStatus = $('#enrollment-status');
        const enrolledCoursesList = $('#enrolled-courses-list');

        $('.enroll-btn').on('click', function(e) {
            e.preventDefault(); 
            const button = $(this);
            // Get course ID from data-course-id attribute (Step 5 requirement)
            const courseId = button.data('course-id');
            const courseName = button.data('course-name');

            // Validate course ID is present
            if (!courseId) {
                alert('Error: Course ID is missing. Please refresh the page and try again.');
                return;
            }

            // Disable button and show loading state
            button.prop('disabled', true)
                .css('opacity', '0.7')
                .html('<svg class="w-4 h-4 inline mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Processing...');
            
            // Hide any previous messages
            enrollmentStatus.hide().empty();

            // Get CSRF token for security (Step 9.3 - CSRF Protection)
            const csrfToken = $('meta[name="csrf-token"]').attr('content') || '';
            const csrfTokenName = '<?= csrf_token() ?>';

            $.ajax({
                url: '<?= site_url('/course/enroll') ?>',
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: { 
                    course_id: courseId,  // System sends course ID to server
                    [csrfTokenName]: csrfToken
                },
                success: function(response) {
                    // Handle both response formats (success/status)
                    const isSuccess = (response.success === true || response.status === 'success');
                    
                    if (isSuccess) {
                        // Use course name from response if available, otherwise use from button data
                        const enrolledCourseName = response.course_name || courseName;
                        
                        // Show success message (no page reload)
                        enrollmentStatus
                            .removeClass('alert-error')
                            .addClass('alert-success')
                            .css({
                                'background': 'linear-gradient(135deg, #10b981 0%, #059669 100%)',
                                'color': 'white',
                                'padding': '1rem 1.5rem',
                                'border-radius': '0.75rem',
                                'margin-bottom': '1.5rem',
                                'display': 'block',
                                'box-shadow': '0 4px 12px rgba(16, 185, 129, 0.3)',
                                'border-left': '4px solid #047857'
                            })
                            .html(`<strong>✓ Success!</strong> You have successfully enrolled in <strong>${enrolledCourseName}</strong>!`)
                            .fadeIn(300);
                        
                        // Hide success message after 5 seconds
                        setTimeout(function() {
                            enrollmentStatus.fadeOut(500);
                        }, 5000);
                        
                        // Get current date for display
                        const now = new Date();
                        const dateStr = now.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        
                        // Create new enrolled course HTML
                        const newCourseHtml = `
                            <div class="flex justify-between items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg academic-border hover:shadow-md transition duration-200 border border-gray-200" id="enrolled-course-${courseId}">
                                <div class="flex-1">
                                    <p class="font-bold text-lg text-gray-800 mb-1">${enrolledCourseName}</p>
                                    <p class="text-sm text-gray-600 mb-2">Enrolled on: ${dateStr}</p>
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs font-bold px-3 py-1 bg-green-100 text-green-800 rounded-full border border-green-200">ENROLLED</span>
                                        <a href="<?= site_url('student/course/') ?>${courseId}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline">View Details →</a>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        // Step 1: Remove "not enrolled" message if it exists and add course to Enrolled Courses
                        const notEnrolledMsg = enrolledCoursesList.find('.text-center:contains("not currently enrolled")').parent();
                        if (notEnrolledMsg.length > 0) {
                            notEnrolledMsg.fadeOut(300, function() {
                                $(this).remove();
                                enrolledCoursesList.prepend(newCourseHtml);
                                $('#enrolled-course-' + courseId).hide().fadeIn(500);
                            });
                        } else {
                        enrolledCoursesList.prepend(newCourseHtml);
                            $('#enrolled-course-' + courseId).hide().fadeIn(500);
                        }
                        
                        // Step 2: Remove the entire table row (button disappears with the row)
                        const courseRow = button.closest('tr');
                        if (courseRow.length > 0) {
                            // Fade out and remove the entire row (button disappears)
                            courseRow.fadeOut(400, function() {
                                $(this).remove();
                                // If no courses left, show empty message
                                if ($('#available-courses-table-body tr').length === 0) {
                                    // Show empty state message
                                    const emptyMessage = `
                                        <tr>
                                            <td colspan="2" class="py-12 text-center">
                                                <div class="text-center py-8 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                                                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <p class="text-gray-500 font-medium">No new courses are currently available for enrollment.</p>
                                                    <p class="text-gray-400 text-sm mt-2">Check back later for new course offerings.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    `;
                                    $('#available-courses-table-body').html(emptyMessage);
                                }
                            });
                        } else {
                            // Fallback: try to find by ID
                            const courseRowById = $('#course-row-' + courseId);
                            if (courseRowById.length > 0) {
                                courseRowById.fadeOut(400, function() {
                                    $(this).remove();
                                    if ($('#available-courses-table-body tr').length === 0) {
                                        const emptyMessage = `
                                            <tr>
                                                <td colspan="2" class="py-8 text-center">
                                                    <div class="text-center py-8 bg-white/10 rounded-lg">
                                                        <svg class="w-16 h-16 mx-auto text-white/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        <p class="text-white/70 italic text-lg">No new courses are currently available for enrollment.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        `;
                                        $('#available-courses-table-body').html(emptyMessage);
                                    }
                                });
                            }
                        }

                    } else {
                        // Show error message
                        enrollmentStatus
                            .removeClass('alert-success')
                            .addClass('alert-error')
                            .css({
                                'background': 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
                                'color': 'white',
                                'padding': '1rem 1.5rem',
                                'border-radius': '0.75rem',
                                'margin-bottom': '1.5rem',
                                'display': 'block',
                                'box-shadow': '0 4px 12px rgba(239, 68, 68, 0.3)',
                                'border-left': '4px solid #b91c1c'
                            })
                            .html(`<strong>✗ Error:</strong> ${response.message || 'Enrollment failed. Please try again.'}`)
                            .fadeIn(300);
                        
                        // Hide error message after 5 seconds
                        setTimeout(function() {
                            enrollmentStatus.fadeOut(500);
                        }, 5000);
                        
                        // Re-enable button
                        button.prop('disabled', false)
                            .css({
                                'background-color': '',
                                'color': '',
                                'cursor': '',
                                'opacity': ''
                            })
                            .html('<svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg> Enroll');
                    }
                },
                error: function(xhr, status, error) {
                    // Show error message
                    enrollmentStatus
                        .removeClass('alert-success')
                        .addClass('alert-error')
                        .css({
                            'background': 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
                            'color': 'white',
                            'padding': '1rem 1.5rem',
                            'border-radius': '0.75rem',
                            'margin-bottom': '1.5rem',
                            'display': 'block',
                            'box-shadow': '0 4px 12px rgba(239, 68, 68, 0.3)',
                            'border-left': '4px solid #b91c1c'
                        })
                        .html('<strong>✗ Error:</strong> Cannot connect to the server. Please try again.')
                        .fadeIn(300);
                    
                    // Hide error message after 5 seconds
                    setTimeout(function() {
                        enrollmentStatus.fadeOut(500);
                    }, 5000);
                    
                    // Re-enable button
                    button.prop('disabled', false)
                        .css({
                            'background-color': '',
                            'color': '',
                            'cursor': '',
                            'opacity': ''
                        })
                        .html('<svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg> Enroll Now');
                }
            });
        });
    });
    </script>

</body>
</html>