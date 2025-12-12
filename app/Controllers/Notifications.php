<?php

namespace App\Controllers;

use App\Models\NotificationModel;

class Notifications extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    /**
     * Get notifications for the current user
     * Returns JSON response with unread count and list of notifications
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function get()
    {
        // Security: Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access. Please log in first.'
            ])->setStatusCode(401);
        }

        // Get user ID from session (secure - never trust client input)
        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid session. Please log in again.'
            ])->setStatusCode(401);
        }

        // Get unread count
        $unreadCount = $this->notificationModel->getUnreadCount($userId);

        // Get latest notifications (limit 5)
        $notifications = $this->notificationModel->getNotificationsForUser($userId, 5);

        // Format notifications for JSON response
        $formattedNotifications = [];
        foreach ($notifications as $notification) {
            $formattedNotifications[] = [
                'id' => $notification['id'],
                'message' => esc($notification['message']), // XSS protection
                'is_read' => (bool) $notification['is_read'],
                'created_at' => $notification['created_at']
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'unread_count' => $unreadCount,
            'notifications' => $formattedNotifications
        ]);
    }

    /**
     * Mark a notification as read
     * Accepts notification ID via POST and marks it as read
     * 
     * @param int $id Notification ID
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function mark_as_read($id)
    {
        // Security: Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access. Please log in first.'
            ])->setStatusCode(401);
        }

        // Get user ID from session
        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid session. Please log in again.'
            ])->setStatusCode(401);
        }

        // Validate notification ID
        if (!is_numeric($id) || $id <= 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid notification ID.'
            ])->setStatusCode(400);
        }

        // Verify the notification belongs to the current user (security check)
        $notification = $this->notificationModel->find($id);
        if (!$notification) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Notification not found.'
            ])->setStatusCode(404);
        }

        if ($notification['user_id'] != $userId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access to this notification.'
            ])->setStatusCode(403);
        }

        // Mark as read
        if ($this->notificationModel->markAsRead($id)) {
            // Get updated unread count
            $unreadCount = $this->notificationModel->getUnreadCount($userId);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Notification marked as read.',
                'unread_count' => $unreadCount
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to mark notification as read.'
            ])->setStatusCode(500);
        }
    }
}
