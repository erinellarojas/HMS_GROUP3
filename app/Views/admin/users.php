<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - ITE311-BUHISAN</title>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Manage Users
                </h1>
                <p class="text-xl text-white/80 mb-8">
                    Welcome, <span class="text-red-300"><?= esc($user_name) ?></span>! Manage system users here.
                </p>
                <a href="<?= site_url('admin/create-user') ?>" class="bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Create New User
                </a>
            </div>

            <!-- Users Table -->
            <div class="glass-card rounded-2xl p-6 md:p-8 text-white">
                <h2 class="text-3xl font-bold mb-6 text-red-300 flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    System Users
                </h2>

                <?php if (empty($users)): ?>
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-white/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <p class="text-white/70 text-lg">No users found.</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="border-b border-white/20">
                                    <th class="text-left py-4 px-4 font-semibold text-red-300">Name</th>
                                    <th class="text-left py-4 px-4 font-semibold text-red-300">Email</th>
                                    <th class="text-center py-4 px-4 font-semibold text-red-300">Role</th>
                                    <th class="text-center py-4 px-4 font-semibold text-red-300">Created</th>
                                    <th class="text-center py-4 px-4 font-semibold text-red-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr class="border-b border-white/10 hover:bg-white/5 transition duration-200">
                                        <td class="py-4 px-4">
                                            <div class="font-semibold text-white"><?= esc($user['name']) ?></div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="text-white/80"><?= esc($user['email']) ?></div>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="bg-red-600/50 px-3 py-1 rounded-full text-sm font-semibold text-red-100 capitalize">
                                                <?= esc($user['role']) ?>
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="bg-gray-600/50 px-3 py-1 rounded-full text-sm font-semibold">
                                                <?= esc(date('M d, Y', strtotime($user['created_at'] ?? 'now'))) ?>
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <div class="flex space-x-2 justify-center">
                                                <a href="<?= site_url('admin/users/view/' . $user['id']) ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded text-sm transition duration-200">
                                                    View
                                                </a>
                                                <a href="<?= site_url('admin/users/edit/' . $user['id']) ?>" class="bg-yellow-500 hover:bg-yellow-600 text-purple-900 font-bold py-1 px-3 rounded text-sm transition duration-200">
                                                    Edit
                                                </a>
                                                <form action="<?= site_url('admin/users/delete/' . $user['id']) ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-sm transition duration-200">
                                                        Delete
                                                    </button>
                                                </form>
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
