<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course - ITE311-BUHISAN</title>
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
        <div class="max-w-2xl w-full">

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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Create New Course
                </h1>
                <p class="text-xl text-white/80 mb-8">
                    Add a new course to the system
                </p>
            </div>

            <!-- Create Form -->
            <div class="glass-card rounded-2xl p-6 md:p-8 text-white">
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="bg-red-500/20 border border-red-500/50 text-red-100 px-4 py-3 rounded-lg mb-6">
                        <ul class="list-disc list-inside">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="bg-red-500/20 border border-red-500/50 text-red-100 px-4 py-3 rounded-lg mb-6">
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('admin/courses/store') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="space-y-6">
                        <div>
                            <label for="course_name" class="block text-sm font-medium text-white/70 mb-2">Course Name</label>
                            <input type="text" id="course_name" name="course_name" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="course_code" class="block text-sm font-medium text-white/70 mb-2">Course Code</label>
                            <input type="text" id="course_code" name="course_code" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="instructor_id" class="block text-sm font-medium text-white/70 mb-2">Instructor</label>
                            <select id="instructor_id" name="instructor_id" required
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                <option value="">Select Instructor</option>
                                <?php foreach ($teachers as $teacher): ?>
                                    <option value="<?= esc($teacher['id']) ?>">
                                        <?= esc($teacher['name']) ?> (<?= esc($teacher['email']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <div>
                            <label for="description" class="block text-sm font-medium text-white/70 mb-2">Description</label>
                            <textarea id="description" name="description" rows="4" required
                                      class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent resize-vertical"></textarea>
                        </div>

                        <div class="flex space-x-4">
                            <button type="submit" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                                Create Course
                            </button>
                            <a href="<?= site_url('admin/courses') ?>" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 text-center">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>
</html>
