<!-- Bootstrap CSS for notifications -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery (load only if not already included in the page) -->
<script>
if (typeof jQuery === 'undefined') {
    document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>');
}
</script>
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <h1 class="text-xl font-bold text-gray-800">ITE311-BUHISAN</h1>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <!-- Common Navigation -->
                </div>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <div class="ml-3 relative">
                    <div class="flex items-center space-x-4">
                        <!-- Notifications Dropdown -->
                        <?php if (session()->get('isLoggedIn')): ?>
                        <div class="dropdown position-relative">
                            <button class="btn btn-link text-gray-600 text-decoration-none position-relative p-2" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; background: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
                                </svg>
                                <span id="notificationBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">
                                    <span id="notificationCount">0</span>
                                    <span class="visually-hidden">unread notifications</span>
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" id="notificationList" aria-labelledby="notificationDropdown" style="min-width: 350px; max-height: 400px; overflow-y: auto;">
                                <li><h6 class="dropdown-header">Notifications</h6></li>
                                <li><hr class="dropdown-divider"></li>
                                <li id="notificationEmpty" class="px-3 py-2 text-muted text-center" style="display: none;">No notifications</li>
                                <li id="notificationLoading" class="px-3 py-2 text-muted text-center">Loading notifications...</li>
                            </ul>
                        </div>
                        <?php endif; ?>
                        <div class="text-sm text-gray-600">
                            <span class="mr-2">Switch role:</span>
                            <a href="<?= site_url('dashboard/switchRole/student') ?>" class="hover:text-blue-600 transition duration-200 mx-1 <?= (session()->get('user_role') === 'student') ? 'font-bold text-blue-600 underline' : '' ?>">Student</a> |
                            <a href="<?= site_url('dashboard/switchRole/teacher') ?>" class="hover:text-blue-600 transition duration-200 mx-1 <?= (session()->get('user_role') === 'teacher') ? 'font-bold text-blue-600 underline' : '' ?>">Teacher</a> |
                            <a href="<?= site_url('dashboard/switchRole/admin') ?>" class="hover:text-blue-600 transition duration-200 mx-1 <?= (session()->get('user_role') === 'admin') ? 'font-bold text-blue-600 underline' : '' ?>">Admin</a>
                        </div>
                        <a href="<?= site_url('logout') ?>" class="border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-4 py-2 rounded-md text-sm font-medium transition-all duration-200">
                            Log Out
                        </a>
                    </div>
                </div>
            </div>
            <div class="-mr-2 flex items-center sm:hidden">
                <!-- Mobile menu button -->
                <button type="button" class="bg-gray-100 inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-blue-600 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="sm:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-white">
            <!-- Mobile Notifications -->
            <?php if (session()->get('isLoggedIn')): ?>
            <div class="px-3 py-2">
                <div class="dropdown">
                    <button class="btn btn-link text-gray-700 text-decoration-none position-relative w-100 text-start p-0" type="button" id="notificationDropdownMobile" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; background: none;">
                        <span class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bell me-2" viewBox="0 0 16 16">
                                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
                            </svg>
                            Notifications
                            <span id="notificationBadgeMobile" class="badge rounded-pill bg-danger ms-2" style="display: none;">
                                <span id="notificationCountMobile">0</span>
                            </span>
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end w-100" id="notificationListMobile" aria-labelledby="notificationDropdownMobile" style="max-height: 300px; overflow-y: auto;">
                        <li><h6 class="dropdown-header">Notifications</h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li id="notificationEmptyMobile" class="px-3 py-2 text-muted text-center" style="display: none;">No notifications</li>
                        <li id="notificationLoadingMobile" class="px-3 py-2 text-muted text-center">Loading notifications...</li>
                    </ul>
                </div>
            </div>
            <hr class="my-2">
            <?php endif; ?>
            <a href="<?= site_url('dashboard') ?>" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>

            <?php if (session()->get('user_role') === 'admin'): ?>
                <a href="<?= site_url('admin/users') ?>" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Users</a>
                <a href="<?= site_url('admin/courses') ?>" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Courses</a>
                <a href="<?= site_url('admin/reports') ?>" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Reports</a>
                <a href="<?= site_url('admin/create-user') ?>" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Create User</a>
            <?php elseif (session()->get('user_role') === 'teacher'): ?>
                <a href="<?= site_url('teacher/courses') ?>" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">My Classes</a>
                <a href="<?= site_url('teacher/assignments') ?>" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Assignments</a>
                <a href="<?= site_url('teacher/grades') ?>" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Grades</a>
            <?php elseif (session()->get('user_role') === 'student'): ?>
                <a href="<?= site_url('student/courses') ?>" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">My Courses</a>
                <a href="<?= site_url('student/assignments') ?>" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Assignments</a>
                <a href="<?= site_url('student/grades') ?>" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Grades</a>
            <?php endif; ?>

            <div class="border-t border-gray-200 pt-2">
                <span class="text-gray-700 text-sm block px-3 py-2">Welcome, <?= session()->get('user_name') ?> (<?= ucfirst(session()->get('user_role')) ?>)</span>
                <div class="px-3 py-2 text-sm text-gray-600">
                    <span class="mr-2">Switch role:</span>
                    <a href="<?= site_url('dashboard/switchRole/student') ?>" class="hover:text-blue-600 transition duration-200 mx-1 <?= (session()->get('user_role') === 'student') ? 'font-bold text-blue-600 underline' : '' ?>">Student</a> |
                    <a href="<?= site_url('dashboard/switchRole/teacher') ?>" class="hover:text-blue-600 transition duration-200 mx-1 <?= (session()->get('user_role') === 'teacher') ? 'font-bold text-blue-600 underline' : '' ?>">Teacher</a> |
                    <a href="<?= site_url('dashboard/switchRole/admin') ?>" class="hover:text-blue-600 transition duration-200 mx-1 <?= (session()->get('user_role') === 'admin') ? 'font-bold text-blue-600 underline' : '' ?>">Admin</a>
                </div>
                <a href="<?= site_url('logout') ?>" class="border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white block px-4 py-2 rounded-md text-base font-medium text-center transition-all duration-200">Log Out</a>
            </div>
        </div>
    </div>
</nav>

<!-- Notification System JavaScript -->
<script>
$(document).ready(function() {
    // Function to fetch and display notifications
    function fetchNotifications() {
        $.get('<?= site_url('notifications') ?>')
            .done(function(response) {
                if (response.status === 'success') {
                    updateNotificationBadge(response.unread_count);
                    updateNotificationList(response.notifications);
                } else {
                    console.error('Error fetching notifications:', response.message);
                    $('#notificationLoading').text('Error loading notifications').show();
                }
            })
            .fail(function(xhr, status, error) {
                console.error('AJAX error:', error);
                $('#notificationLoading').text('Error loading notifications').show();
            });
    }

    // Function to update the notification badge (both desktop and mobile)
    function updateNotificationBadge(count) {
        // Desktop badge
        const badge = $('#notificationBadge');
        const countSpan = $('#notificationCount');
        
        // Mobile badge
        const badgeMobile = $('#notificationBadgeMobile');
        const countSpanMobile = $('#notificationCountMobile');
        
        if (count > 0) {
            countSpan.text(count);
            badge.show();
            countSpanMobile.text(count);
            badgeMobile.show();
        } else {
            badge.hide();
            badgeMobile.hide();
        }
    }

    // Function to update the notification list (both desktop and mobile)
    function updateNotificationList(notifications) {
        // Update desktop list
        updateNotificationListForElement('#notificationList', '#notificationEmpty', '#notificationLoading', notifications);
        
        // Update mobile list
        updateNotificationListForElement('#notificationListMobile', '#notificationEmptyMobile', '#notificationLoadingMobile', notifications);
    }
    
    // Helper function to update notification list for a specific element
    function updateNotificationListForElement(listSelector, emptySelector, loadingSelector, notifications) {
        const list = $(listSelector);
        const emptyMsg = $(emptySelector);
        const loadingMsg = $(loadingSelector);
        
        // Remove existing notification items (except header, divider, empty, and loading messages)
        list.find('li.notification-item').remove();
        loadingMsg.hide();
        
        if (notifications.length === 0) {
            emptyMsg.show();
        } else {
            emptyMsg.hide();
            
            // Add each notification to the list
            notifications.forEach(function(notification) {
                const isRead = notification.is_read;
                const alertClass = isRead ? 'alert-secondary' : 'alert-info';
                const readButton = isRead ? '' : 
                    '<button class="btn btn-sm btn-outline-primary mt-2 mark-read-btn" data-id="' + 
                    escapeHtml(notification.id) + '">Mark as Read</button>';
                
                const notificationHtml = 
                    '<li class="notification-item" data-notification-id="' + escapeHtml(notification.id) + '">' +
                    '<div class="alert ' + alertClass + ' m-2 mb-0" role="alert">' +
                    '<p class="mb-1">' + escapeHtml(notification.message) + '</p>' +
                    '<small class="text-muted">' + escapeHtml(notification.created_at) + '</small>' +
                    readButton +
                    '</div>' +
                    '</li>';
                
                // Insert before the empty message (or at the end if it doesn't exist)
                if (emptyMsg.length) {
                    emptyMsg.before(notificationHtml);
                } else {
                    list.append(notificationHtml);
                }
            });
        }
    }

    // Function to escape HTML (XSS protection)
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // Handle "Mark as Read" button clicks
    $(document).on('click', '.mark-read-btn', function() {
        const notificationId = $(this).data('id');
        const button = $(this);
        
        // Disable button to prevent double-clicks
        button.prop('disabled', true).text('Marking...');
        
        $.post('<?= site_url('notifications/mark_read') ?>/' + notificationId)
            .done(function(response) {
                // SUCCESS: Notification marked as read
                if (response.status === 'success') {
                    // 1. Update badge count immediately (both desktop and mobile)
                    updateNotificationBadge(response.unread_count);
                    
                    // 2. Smoothly remove notification from BOTH lists (desktop and mobile)
                    const notificationItems = $('li.notification-item[data-notification-id="' + notificationId + '"]');
                    
                    // Smooth fade-out animation (500ms for smooth, elegant disappearance)
                    notificationItems.fadeOut(500, function() {
                        $(this).remove();
                        
                        // Show empty message if no notifications remain (with smooth fade-in)
                        if ($('#notificationList').find('li.notification-item').length === 0) {
                            $('#notificationEmpty').fadeIn(300);
                        }
                        if ($('#notificationListMobile').find('li.notification-item').length === 0) {
                            $('#notificationEmptyMobile').fadeIn(300);
                        }
                    });
                    
                    // No error message on success - everything worked perfectly
                } else {
                    // ERROR: Only show error message if something FAILED
                    console.error('Error marking notification as read:', response.message);
                    alert('Error: ' + response.message);
                    button.prop('disabled', false).text('Mark as Read');
                }
            })
            .fail(function(xhr, status, error) {
                // ERROR: Only show error message if request FAILED
                console.error('Failed to mark notification as read:', error);
                alert('Failed to mark notification as read. Please try again.');
                button.prop('disabled', false).text('Mark as Read');
            });
    });

    // Fetch notifications on page load
    fetchNotifications();
    
    // Optionally: Fetch notifications every 60 seconds for real-time updates
    setInterval(fetchNotifications, 60000);
});
</script>
