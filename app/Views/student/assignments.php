<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Assignments - ITE311-BUHISAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background: #7c3aed;
            min-height: 100vh;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-600 to-indigo-800">

    <?= view('templates/header') ?>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">
                    My Assignments
                    <span class="text-xl font-normal text-purple-200">(<?= esc($user_name) ?>)</span>
                </h1>
                <p class="text-indigo-200">View and manage your course assignments.</p>
            </div>

            <?php if (!empty($assignments)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($assignments as $assignment): ?>
                        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20 hover:bg-white/20 transition duration-200">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl">📝</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    <?php
                                    switch($assignment['status']) {
                                        case 'Submitted':
                                            echo 'bg-green-100 text-green-800';
                                            break;
                                        case 'Pending':
                                            echo 'bg-yellow-100 text-yellow-800';
                                            break;
                                        case 'Overdue':
                                            echo 'bg-red-100 text-red-800';
                                            break;
                                        default:
                                            echo 'bg-gray-100 text-gray-800';
                                    }
                                    ?>
                                ">
                                    <?= esc($assignment['status']) ?>
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2"><?= esc($assignment['title']) ?></h3>
                            <p class="text-indigo-200 text-sm mb-2">Course: <?= esc($assignment['course']) ?></p>
                            <p class="text-white/80 text-sm mb-4"><?= esc($assignment['description']) ?></p>
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    <span class="text-indigo-200">Due: </span>
                                    <span class="text-white font-medium">
                                        <?php
                                        $dueDate = strtotime($assignment['due_date']);
                                        $today = strtotime(date('Y-m-d'));
                                        $daysDiff = ceil(($dueDate - $today) / (60*60*24));

                                        if ($daysDiff < 0) {
                                            echo '<span class="text-red-300">Overdue</span>';
                                        } elseif ($daysDiff === 0) {
                                            echo '<span class="text-yellow-300">Today</span>';
                                        } elseif ($daysDiff === 1) {
                                            echo '<span class="text-orange-300">Tomorrow</span>';
                                        } elseif ($daysDiff <= 7) {
                                            echo '<span class="text-blue-300">' . $daysDiff . ' days</span>';
                                        } else {
                                            echo '<span class="text-green-300">' . date('M d, Y', $dueDate) . '</span>';
                                        }
                                        ?>
                                    </span>
                                </div>
                                <?php if ($assignment['status'] === 'Pending'): ?>
                                    <a href="/student/assignment/<?= $assignment['id'] ?>/submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                        Submit
                                    </a>
                                <?php elseif ($assignment['status'] === 'Submitted'): ?>
                                    <span class="text-green-300 font-medium">Submitted ✓</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 border border-white/20 text-center">
                    <span class="text-6xl mb-4 block">📝</span>
                    <h3 class="text-2xl font-bold text-white mb-2">No Assignments</h3>
                    <p class="text-indigo-200 mb-6">You don't have any assignments at the moment. Check back later!</p>
                    <a href="/student/courses" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                        View My Courses
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
