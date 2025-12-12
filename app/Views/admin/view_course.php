<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Course - ITE311-BUHISAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="gradient-bg">

    <?= view('templates/header') ?>

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-4xl w-full">

            <!-- Navigation -->
            <div class="w-full text-left mb-8">
                <a href="<?= site_url('admin/courses') ?>" class="text-white/80 hover:text-white transition duration-200 inline-flex items-center text-lg">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Courses
                </a>
            </div>

            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Course Details
                </h1>
                <p class="text-xl text-white/80 mb-8">
                    Viewing details for <span class="text-red-300"><?= esc($course['course_name']) ?></span>
                </p>
            </div>

            <!-- Course Details Card -->
            <div class="glass-card rounded-2xl p-6 md:p-8 text-white">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-2xl font-bold mb-6 text-red-300">Course Information</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-1">Course Name</label>
                                <p class="text-white text-lg font-semibold"><?= esc($course['course_name']) ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-1">Course Code</label>
                                <p class="text-white text-lg"><?= esc($course['course_code'] ?? 'N/A') ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-1">Instructor</label>
                                <p class="text-white text-lg"><?= esc($course['instructor_name'] ?? 'Not assigned') ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-1">Description</label>
                                <p class="text-white text-lg leading-relaxed"><?= esc($course['description'] ?? 'No description provided') ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-1">Created</label>
                                <p class="text-white text-lg">
                                    <?= esc(date('F d, Y \a\t g:i A', strtotime($course['created_at']))) ?>
                                </p>
                            </div>
                            <?php if (isset($course['updated_at']) && $course['updated_at']): ?>
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-1">Last Updated</label>
                                <p class="text-white text-lg">
                                    <?= esc(date('F d, Y \a\t g:i A', strtotime($course['updated_at']))) ?>
                                </p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-2xl font-bold mb-6 text-red-300">Actions</h3>
                        <div class="space-y-4">
                            <a href="<?= site_url('admin/courses/edit/' . $course['id']) ?>" class="w-full bg-yellow-500 hover:bg-yellow-600 text-purple-900 font-bold py-3 px-6 rounded-lg transition duration-200 inline-flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit Course
                            </a>
                            <a href="<?= site_url('admin/course/' . $course['id'] . '/upload') ?>" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 inline-flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                Upload Material
                            </a>
                            <form action="<?= site_url('admin/courses/delete/' . $course['id']) ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this course? This action cannot be undone.')">
                                <?= csrf_field() ?>
                                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 inline-flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Delete Course
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Materials Section -->
            <div class="glass-card rounded-2xl p-6 md:p-8 text-white mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-red-300">Course Materials</h3>
                    <a href="<?= site_url('admin/course/' . $course['id'] . '/upload') ?>" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-flex items-center text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Upload New
                    </a>
                </div>

                <?php if (!empty($materials)): ?>
                    <div class="space-y-3">
                        <?php foreach ($materials as $material): ?>
                            <div class="bg-white/10 rounded-lg p-4 flex justify-between items-center hover:bg-white/20 transition duration-200">
                                <div class="flex items-center flex-1">
                                    <svg class="w-8 h-8 text-red-300 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-white font-semibold"><?= esc($material['file_name']) ?></p>
                                        <p class="text-white/60 text-sm">Uploaded: <?= esc(date('M d, Y g:i A', strtotime($material['created_at']))) ?></p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="<?= site_url('materials/download/' . $material['id']) ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-flex items-center text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Download
                                    </a>
                                    <a href="<?= site_url('materials/delete/' . $material['id']) ?>" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200 inline-flex items-center text-sm" onclick="return confirm('Are you sure you want to delete this material?')">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Delete
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 mx-auto text-white/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-white/70 italic">No materials uploaded yet.</p>
                        <a href="<?= site_url('admin/course/' . $course['id'] . '/upload') ?>" class="mt-4 inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            Upload First Material
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

</body>
</html>
