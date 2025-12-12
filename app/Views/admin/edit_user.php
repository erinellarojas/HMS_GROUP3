<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - ITE311-BUHISAN</title>
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
                <a href="<?= site_url('admin/users') ?>" class="text-white/80 hover:text-white transition duration-200 inline-flex items-center text-lg">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Users
                </a>
            </div>

            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Edit User
                </h1>
                <p class="text-xl text-white/80 mb-8">
                    Editing <span class="text-red-300"><?= esc($user['name']) ?></span>
                </p>
            </div>

            <!-- Edit Form -->
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

                <form action="<?= site_url('admin/users/update/' . $user['id']) ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-white/70 mb-2">Full Name</label>
                            <input type="text" id="name" name="name" value="<?= esc($user['name']) ?>" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-white/70 mb-2">Email Address</label>
                            <input type="email" id="email" name="email" value="<?= esc($user['email']) ?>" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-medium text-white/70 mb-2">Role</label>
                            <select id="role" name="role" required
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                <option value="student" <?= ($user['role'] === 'student') ? 'selected' : '' ?>>Student</option>
                                <option value="teacher" <?= ($user['role'] === 'teacher') ? 'selected' : '' ?>>Teacher</option>
                                <option value="admin" <?= ($user['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-white/70 mb-2">New Password (leave blank to keep current)</label>
                            <input type="password" id="password" name="password"
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <p class="text-xs text-white/60 mt-1">Leave empty if you don't want to change the password</p>
                        </div>

                        <div class="flex space-x-4">
                            <button type="submit" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                                Update User
                            </button>
                            <a href="<?= site_url('admin/users/view/' . $user['id']) ?>" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 text-center">
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
