<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments - ITE311-BUHISAN</title>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Assignments
                </h1>
                <p class="text-xl text-white/80 mb-8">
                    Welcome, <span class="text-yellow-300"><?= esc($user_name) ?></span>! Manage your course assignments here.
                </p>
            </div>

            <!-- Assignments Table -->
            <div class="glass-card rounded-2xl p-6 md:p-8 text-white">
                <h2 class="text-3xl font-bold mb-6 text-blue-300 flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Course Assignments
                </h2>

                <?php if (empty($assignments)): ?>
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-white/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p class="text-white/70 text-lg">No assignments created yet.</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="border-b border-white/20">
                                    <th class="text-left py-4 px-4 font-semibold text-blue-300">Assignment</th>
                                    <th class="text-left py-4 px-4 font-semibold text-blue-300">Course</th>
                                    <th class="text-center py-4 px-4 font-semibold text-blue-300">Due Date</th>
                                    <th class="text-center py-4 px-4 font-semibold text-blue-300">Submissions</th>
                                    <th class="text-center py-4 px-4 font-semibold text-blue-300">Status</th>
                                    <th class="text-center py-4 px-4 font-semibold text-blue-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assignments as $assignment): ?>
                                    <tr class="border-b border-white/10 hover:bg-white/5 transition duration-200">
                                        <td class="py-4 px-4">
                                            <div class="font-semibold text-white"><?= esc($assignment['title']) ?></div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="text-white/80"><?= esc($assignment['course']) ?></div>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="bg-purple-600/50 px-3 py-1 rounded-full text-sm font-semibold">
                                                <?= esc(date('M d, Y', strtotime($assignment['due_date']))) ?>
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="bg-green-600/50 px-3 py-1 rounded-full text-sm font-semibold">
                                                <?= esc($assignment['submissions']) ?>/<?= esc($assignment['total_students']) ?>
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <?php if ($assignment['status'] === 'Active'): ?>
                                                <span class="bg-green-600/50 px-3 py-1 rounded-full text-sm font-semibold text-green-100">
                                                    <?= esc($assignment['status']) ?>
                                                </span>
                                            <?php elseif ($assignment['status'] === 'Graded'): ?>
                                                <span class="bg-blue-600/50 px-3 py-1 rounded-full text-sm font-semibold text-blue-100">
                                                    <?= esc($assignment['status']) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="bg-gray-600/50 px-3 py-1 rounded-full text-sm font-semibold text-gray-100">
                                                    <?= esc($assignment['status']) ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <div class="flex space-x-2 justify-center">
                                                <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded text-sm transition duration-200">
                                                    View
                                                </a>
                                                <a href="#" class="bg-yellow-500 hover:bg-yellow-600 text-purple-900 font-bold py-1 px-3 rounded text-sm transition duration-200">
                                                    Edit
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

</body>
</html>
