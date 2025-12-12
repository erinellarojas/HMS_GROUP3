<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - ITE311-BUHISAN</title>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    User Management
                </h1>
                <p class="text-xl text-white/80 mb-8">
                    Manage all system users and their permissions
                </p>
            </div>

            <!-- Users Table -->
            <div class="glass-card rounded-2xl p-8 text-white overflow-x-auto">
                <div class="mb-6 flex justify-between items-center">
                    <h2 class="text-2xl font-bold">All Users</h2>
                    <a href="<?= site_url('admin/create-user') ?>" class="bg-white text-purple-600 hover:bg-purple-50 font-bold py-2 px-6 rounded-lg transition duration-200 shadow-md">
                        Create New User
                    </a>
                </div>
                
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-white/20">
                            <th class="pb-4">ID</th>
                            <th class="pb-4">Name</th>
                            <th class="pb-4">Email</th>
                            <th class="pb-4">Role</th>
                            <th class="pb-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                            <tr class="border-b border-white/10 hover:bg-white/5">
                                <td class="py-4"><?= esc($user['id']) ?></td>
                                <td class="py-4"><?= esc($user['name']) ?></td>
                                <td class="py-4"><?= esc($user['email']) ?></td>
                                <td class="py-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $user['role'] === 'admin' ? 'bg-red-500/50' : ($user['role'] === 'teacher' ? 'bg-blue-500/50' : 'bg-green-500/50') ?>">
                                        <?= esc(ucfirst($user['role'])) ?>
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex gap-2">
                                        <a href="<?= site_url('admin/users/view/' . $user['id']) ?>" class="text-blue-300 hover:text-blue-200">View</a>
                                        <a href="<?= site_url('admin/users/edit/' . $user['id']) ?>" class="text-yellow-300 hover:text-yellow-200">Edit</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-8 text-center text-white/60">No users found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</body>
</html>
