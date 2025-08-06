<?php
// 代码生成时间: 2025-08-06 14:19:48
use Cake\Core\Configure;
use Cake\Core\Exception;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Routing\Router;

class NotificationSystem {

    private $email;

    /*
     * Constructor to initialize the Email instance.
     *
     * @param Email $email The Email instance to use for sending notifications.
     */
    public function __construct(Email $email) {
        $this->email = $email;
    }

    /*
     * Send a notification to a user.
     *
     * @param string $to The email address of the recipient.
     * @param string $subject The subject of the notification email.
     * @param string $message The message content of the notification email.
     * @param string $view The view file to render the email content from.
     * @return bool Returns true on success, false on failure.
     */
    public function sendNotification($to, $subject, $message, $view) {
        try {
            $this->email->setTo($to)
                      ->setSubject($subject)
                      ->setViewRenderer(Configure::read('View') ? Configure::read('View') : null)
                      ->setTemplate($view)
                      ->setHelpers(['Html']);

            // Add more email settings if needed

            if ($this->email->send($message)) {
                Log::write('info', 'Notification sent successfully to ' . $to);
                return true;
            } else {
                Log::write('error', 'Failed to send notification to ' . $to);
                return false;
            }
        } catch (Exception $e) {
            Log::write('error', 'Error sending notification: ' . $e->getMessage());
            return false;
        }
    }

    /*
     * Set the Email instance to use for sending notifications.
     *
     * @param Email $email The Email instance to use.
     */
    public function setEmail(Email $email) {
        $this->email = $email;
    }

    /*
     * Get the Email instance being used for sending notifications.
     *
     * @return Email The Email instance.
     */
    public function getEmail() {
        return $this->email;
    }

}
