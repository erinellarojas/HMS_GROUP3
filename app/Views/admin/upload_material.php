<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Material - ITE311-BUHISAN</title>
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
                <a href="<?= site_url('admin/courses/view/' . $course['id']) ?>" class="text-white/80 hover:text-white transition duration-200 inline-flex items-center text-lg">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Course Details
                </a>
            </div>

            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Upload Material
                </h1>
                <p class="text-xl text-white/80 mb-8">
                    Upload learning materials for <span class="text-red-300"><?= esc($course['course_name']) ?></span>
                </p>
            </div>

            <!-- Upload Form -->
            <div class="glass-card rounded-2xl p-6 md:p-8 text-white">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="bg-red-500/20 border border-red-500/50 text-red-100 px-4 py-3 rounded-lg mb-6">
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="bg-green-500/20 border border-green-500/50 text-green-100 px-4 py-3 rounded-lg mb-6">
                        <?= esc(session()->getFlashdata('success')) ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($validation) && $validation->hasError('material_file')): ?>
                    <div class="bg-red-500/20 border border-red-500/50 text-red-100 px-4 py-3 rounded-lg mb-6">
                        <?= esc($validation->getError('material_file')) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('admin/course/' . $course['id'] . '/upload') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="space-y-6">
                        <div>
                            <label for="material_file" class="block text-sm font-medium text-white/70 mb-2">Select File</label>
                            <input type="file" id="material_file" name="material_file" required
                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.jpg,.jpeg,.png"
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-white/20 file:text-white hover:file:bg-white/30 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <p class="text-white/60 text-xs mt-2">
                                Allowed file types: PDF, DOC, DOCX, PPT, PPTX, TXT, JPG, JPEG, PNG<br>
                                Maximum file size: 10MB
                            </p>
                        </div>

                        <div class="flex space-x-4">
                            <button type="submit" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 inline-flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                Upload Material
                            </button>
                            <a href="<?= site_url('admin/courses/view/' . $course['id']) ?>" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 text-center">
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
