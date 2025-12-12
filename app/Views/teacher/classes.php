<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Classes - ITE311-BUHISAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <div class="max-w-6xl w-full">

            <!-- Navigation -->
            <div class="w-full text-left mb-8">
                <a href="<?= site_url('dashboard') ?>" class="text-white/80 hover:text-white transition duration-200 inline-flex items-center text-lg">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Dashboard
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
                    My Classes
                </h1>
                <p class="text-xl text-white/80 mb-8">
                    Welcome, <span class="text-yellow-300"><?= esc($user_name) ?></span>! Manage your teaching classes here.
                </p>
            </div>

            <!-- Classes Grid -->
            <div class="glass-card rounded-2xl p-6 md:p-8 text-white">
                <h2 class="text-3xl font-bold mb-6 text-yellow-300 flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Teaching Classes
                </h2>

                <?php if (empty($classes)): ?>
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-white/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <p class="text-white/70 text-lg">No classes assigned yet.</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($classes as $class): ?>
                            <div class="bg-white/10 rounded-lg p-6 hover:bg-white/20 transition duration-200 border border-white/20">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-xl font-bold text-yellow-300"><?= esc($class['name']) ?></h3>
                                    <span class="bg-yellow-600/50 px-3 py-1 rounded-full text-sm font-semibold text-yellow-100">
                                        <?= esc($class['status']) ?>
                                    </span>
                                </div>
                                <div class="space-y-2 text-sm text-white/80">
                                    <p><strong>Code:</strong> <?= esc($class['code']) ?></p>
                                    <p><strong>Schedule:</strong> <?= esc($class['schedule']) ?></p>
                                    <p><strong>Students:</strong> <?= esc($class['students_count']) ?></p>
                                </div>
                                <div class="mt-4 flex space-x-2">
                                    <a href="<?= site_url('teacher/course/' . $class['id']) ?>" class="bg-yellow-500 hover:bg-yellow-600 text-purple-900 font-bold py-2 px-4 rounded-lg transition duration-200 text-sm flex-1 text-center">
                                        View Details
                                    </a>
                                    <a href="<?= site_url('admin/course/' . $class['id'] . '/upload') ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200 text-sm flex-1 text-center">
                                        Upload Material
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

</body>
</html>
