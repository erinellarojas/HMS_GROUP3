<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details - ITE311-BUHISAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            min-height: 100vh;
        }
        .glass-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        .gradient-bg {
            background: #ffffff;
        }
    </style>
</head>
<body class="gradient-bg">

    <?= view('templates/header') ?>

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-4xl w-full">

            <!-- Navigation -->
            <div class="w-full text-left mb-8">
                <a href="<?= site_url('student/courses') ?>" class="text-gray-700 hover:text-gray-900 transition duration-200 inline-flex items-center text-lg">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to My Courses
                </a>
            </div>

            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-6">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                    Course Details
                </h1>
                <p class="text-xl text-gray-600 mb-8">
                    Viewing details for <span class="text-blue-600"><?= esc($course['course_name']) ?></span>
                </p>
            </div>

            <!-- Course Details Card -->
            <div class="glass-card rounded-2xl p-6 md:p-8 shadow-md border border-gray-200">
                <div>
                    <h3 class="text-2xl font-bold mb-6 text-blue-600">Course Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Course Name</label>
                            <p class="text-gray-800 text-lg font-semibold"><?= esc($course['course_name']) ?></p>
                        </div>
                        <?php if (!empty($course['course_code'])): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Course Code</label>
                            <p class="text-gray-800 text-lg"><?= esc($course['course_code']) ?></p>
                        </div>
                        <?php endif; ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Instructor</label>
                            <p class="text-gray-800 text-lg"><?= !empty($course['instructor_name']) ? esc($course['instructor_name']) : 'Not assigned' ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Description</label>
                            <p class="text-gray-700 text-lg leading-relaxed"><?= esc($course['description'] ?? 'No description provided') ?></p>
                        </div>
                        <?php if ($enrollment): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Enrollment Date</label>
                            <p class="text-gray-800 text-lg">
                                <?= esc(date('F d, Y \a\t g:i A', strtotime($enrollment['enrollment_date']))) ?>
                            </p>
                        </div>
                        <?php endif; ?>
                        <?php if (isset($course['created_at']) && $course['created_at']): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Course Created</label>
                            <p class="text-gray-800 text-lg">
                                <?= esc(date('F d, Y', strtotime($course['created_at']))) ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Course Materials Section -->
            <?php if (!empty($materials)): ?>
            <div class="glass-card rounded-2xl p-6 md:p-8 shadow-md border border-gray-200 mt-8">
                <h3 class="text-2xl font-bold mb-6 text-blue-600">Course Materials</h3>
                <div class="space-y-3">
                    <?php foreach ($materials as $material): ?>
                        <div class="bg-gray-50 rounded-lg p-4 flex justify-between items-center hover:bg-gray-100 transition duration-200 border border-gray-200">
                            <div class="flex items-center flex-1">
                                <svg class="w-8 h-8 text-blue-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-gray-800 font-semibold"><?= esc($material['file_name']) ?></p>
                                    <p class="text-gray-500 text-sm">Uploaded: <?= esc(date('M d, Y g:i A', strtotime($material['created_at']))) ?></p>
                                </div>
                            </div>
                            <a href="<?= site_url('materials/download/' . $material['id']) ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="glass-card rounded-2xl p-6 md:p-8 shadow-md border border-gray-200 mt-8">
                <div class="text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-600 italic">No materials available for this course yet.</p>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>

</body>
</html>
