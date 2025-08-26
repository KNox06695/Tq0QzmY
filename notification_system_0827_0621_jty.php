<?php
// 代码生成时间: 2025-08-27 06:21:51
// Notification System using PHP and CAKEPHP framework

require 'vendor/autoload.php';

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Routing\Router;

class NotificationSystem {

    private $email;
    private $notificationTable;

    public function __construct() {
        $this->email = new Email('default');
        $this->notificationTable = TableRegistry::getTableLocator()->get('Notifications');
    }

    // Send notification to a user
    public function sendNotification($userId, $message) {
        try {
            // Load the user's email from the database
            $user = $this->notificationTable->find('all', [
                'conditions' => ['Notifications.user_id' => $userId]
            ])->first();

            if (!$user) {
                throw new \Exception('User not found');
            }

            // Set email configuration
            $this->email->setTo($user->email)
                      ->setSubject('Notification')
                      ->setEmailFormat('html')
                      ->send($message);

            return true;
        } catch (Exception $e) {
            // Log the error and return false
            error_log($e->getMessage());
            return false;
        }
    }

    // Add a new notification
    public function addNotification($userId, $message) {
        $notification = $this->notificationTable->newEntity([
            'user_id' => $userId,
            'message' => $message
        ]);

        if (!$this->notificationTable->save($notification)) {
            throw new \Exception('Failed to save notification');
        }
    }

}

// Usage example
$notificationSystem = new NotificationSystem();
$notificationSystem->sendNotification(1, 'You have a new message.');
$notificationSystem->addNotification(1, 'You have a new message.');
