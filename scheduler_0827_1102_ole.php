<?php
// 代码生成时间: 2025-08-27 11:02:24
use Cake\Console\CommandCollection;
use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Utility\Hash;
use Cake\I18n\FrozenTime;
use Cake\Shell;

// Ensure the CakePHP application bootstrap file is loaded.
require '/path/to/your/cakephp-app/config/bootstrap.php';

class SchedulerShell extends Shell {
    public function initialize(): void {
        parent::initialize();
        // Initialize scheduling jobs
        $this->scheduleJobs();
    }

    // Define the jobs that need to be scheduled.
    private function scheduleJobs(): void {
        // Define the jobs and their frequencies.
        $jobs = [
            'EmailJob' => '*/5 * * * *', // Runs every 5 minutes.
            // Add more jobs here with their respective cron expressions.
        ];

        foreach ($jobs as $job => $cron) {
            // Schedule each job using the cron expression.
            $this->out("Scheduling job: {$job} to run every {$cron}.");
            $this->ScheduleJob($job, $cron);
        }
    }

    // Schedule a single job.
    private function ScheduleJob(string $job, string $cron): void {
        try {
            // Use the CakePHP console to schedule the job.
            $command = "bin/cake $job";
            $success = $this->runCommand(['cron', 'add', $cron, $command]);
            if ($success) {
                $this->out("Job scheduled successfully.");
            } else {
                $this->out("Failed to schedule job.");
            }
        } catch (Exception $e) {
            $this->err("Error scheduling job: " . $e->getMessage());
        }
    }
}

// Run the shell.
(new SchedulerShell())->runCommand(['init']);