<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Entry - ITE311-BUHISAN</title>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Grade Entry
                </h1>
                <p class="text-xl text-white/80 mb-8">
                    Review and grade student submissions
                </p>
            </div>

            <!-- Grades Table -->
            <div class="glass-card rounded-2xl p-8 text-white overflow-x-auto">
                <h2 class="text-2xl font-bold mb-6">Pending Grade Entries</h2>
                
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-white/20">
                            <th class="pb-4">Assignment</th>
                            <th class="pb-4">Course</th>
                            <th class="pb-4">Student</th>
                            <th class="pb-4">Submitted Date</th>
                            <th class="pb-4">Current Grade</th>
                            <th class="pb-4">Status</th>
                            <th class="pb-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($grade_entries)): ?>
                            <?php foreach ($grade_entries as $entry): ?>
                            <tr class="border-b border-white/10 hover:bg-white/5">
                                <td class="py-4"><?= esc($entry['assignment']) ?></td>
                                <td class="py-4"><?= esc($entry['course']) ?></td>
                                <td class="py-4"><?= esc($entry['student']) ?></td>
                                <td class="py-4"><?= esc($entry['submitted_date']) ?></td>
                                <td class="py-4">
                                    <?php if ($entry['current_grade'] === 'Pending'): ?>
                                        <span class="text-yellow-300">Pending</span>
                                    <?php else: ?>
                                        <span class="text-green-300"><?= esc($entry['current_grade']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $entry['status'] === 'Graded' ? 'bg-green-500/50' : 'bg-yellow-500/50' ?>">
                                        <?= esc($entry['status']) ?>
                                    </span>
                                </td>
                                <td class="py-4">
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded text-sm transition duration-200">
                                        Grade
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="py-8 text-center text-white/60">No grade entries found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</body>
</html>
