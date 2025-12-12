<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Grades - ITE311-BUHISAN</title>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    My Grades
                </h1>
                <p class="text-xl text-white/80 mb-8">
                    Welcome, <span class="text-yellow-300"><?= esc($user_name) ?></span>! Here's your academic performance overview.
                </p>
            </div>

            <!-- GPA Summary -->
            <div class="glass-card rounded-2xl p-6 md:p-8 text-white mb-8">
                <div class="text-center">
                    <h2 class="text-2xl font-bold mb-4 text-purple-300">Overall GPA</h2>
                    <div class="text-6xl font-bold text-yellow-300 mb-2">
                        <?php if ($gpa !== 'N/A'): ?>
                            <?= number_format($gpa, 2) ?>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </div>
                    <p class="text-white/70">Based on completed courses</p>
                </div>
            </div>

            <!-- Grades Table -->
            <div class="glass-card rounded-2xl p-6 md:p-8 text-white">
                <h2 class="text-3xl font-bold mb-6 text-purple-300 flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Course Grades
                </h2>

                <?php if (empty($grades)): ?>
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-white/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <p class="text-white/70 text-lg">No grades available yet.</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="border-b border-white/20">
                                    <th class="text-left py-4 px-4 font-semibold text-purple-300">Course</th>
                                    <th class="text-center py-4 px-4 font-semibold text-purple-300">Midterm</th>
                                    <th class="text-center py-4 px-4 font-semibold text-purple-300">Final</th>
                                    <th class="text-center py-4 px-4 font-semibold text-purple-300">Overall</th>
                                    <th class="text-center py-4 px-4 font-semibold text-purple-300">Grade</th>
                                    <th class="text-center py-4 px-4 font-semibold text-purple-300">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($grades as $grade): ?>
                                    <tr class="border-b border-white/10 hover:bg-white/5 transition duration-200">
                                        <td class="py-4 px-4">
                                            <div class="font-semibold text-white"><?= esc($grade['course']) ?></div>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="bg-blue-600/50 px-3 py-1 rounded-full text-sm font-semibold">
                                                <?= esc($grade['midterm']) ?>
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="bg-green-600/50 px-3 py-1 rounded-full text-sm font-semibold">
                                                <?= esc($grade['final']) ?>
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="bg-purple-600/50 px-3 py-1 rounded-full text-sm font-semibold">
                                                <?= esc($grade['overall']) ?>
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="bg-yellow-600/50 px-3 py-1 rounded-full text-sm font-bold text-yellow-100">
                                                <?= esc($grade['grade']) ?>
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <?php if ($grade['status'] === 'Passed'): ?>
                                                <span class="bg-green-600/50 px-3 py-1 rounded-full text-sm font-semibold text-green-100">
                                                    <?= esc($grade['status']) ?>
                                                </span>
                                            <?php elseif ($grade['status'] === 'Failed'): ?>
                                                <span class="bg-red-600/50 px-3 py-1 rounded-full text-sm font-semibold text-red-100">
                                                    <?= esc($grade['status']) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="bg-gray-600/50 px-3 py-1 rounded-full text-sm font-semibold text-gray-100">
                                                    <?= esc($grade['status']) ?>
                                                </span>
                                            <?php endif; ?>
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
