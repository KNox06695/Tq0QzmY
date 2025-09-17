<?php
// 代码生成时间: 2025-09-18 01:02:07
use Cake\Core\Configure;
use Cake\Core\Singleton;
use Cake\Core\Exception\CakeException;
use Cake\Log\Log;
use Cake\Console\ConsoleIo;
use Cake\Console\Shell;
use Cake\Event\EventManager;
use Cake\Event\EventManagerTrait;
use Cake\Console\ConsoleOptionParser;
use Cake\Console\Exception\CommandAbortedException;

class SchedulerShell extends Shell {
    use EventManagerTrait;

    /**
     * Define the task scheduler.
     *
     * @return void
     */
    public function initialize(): void {
        parent::initialize();
        $this->loadModel('Tasks');
    }

    /**
     * Main method for the scheduler shell.
     *
     * @return void
     */
    public function main(): void {
        $this->out('Scheduler Shell');
        $this->out('---------------');
        $this->hr();

        // Check if a task name was provided
        $task = $this->params['task'] ?? null;
        if (!$task) {
            $this->err('Please provide a task to run.');
            return $this->abort();
        }

        // Get the task class instance
        $taskClass = $this->Tasks->getTask($task);
        if (!$taskClass) {
            $this->err('Task not found.');
            return $this->abort();
        }

        // Run the task
        try {
            $result = $taskClass->run();
            $this->out('Task completed successfully.');
        } catch (Exception $e) {
            $this->err('Error running task: ' . $e->getMessage());
        }
    }

    /**
     * Help method for the scheduler shell.
     *
     * @return void
     */
    public function getOptionParser(): ConsoleOptionParser {
        $parser = new ConsoleOptionParser(
            'console',
            false
        );
        $parser->setDescription(
            'This shell is used to schedule and run tasks.'
        );
        $parser->addArgument('task', [
            'help' => 'The task to schedule.',
            'required' => true,
        ]);
        return $parser;
    }
}

/**
 * Abstract class for tasks.
 *
 * All tasks should inherit from this class.
 */
abstract class Task {
    /**
     * Run the task.
     *
     * @return mixed
     */
    abstract public function run();
}

/**
 * Example task class.
 *
 * This task simply logs a message to indicate it has run.
 */
class LogTask extends Task {
    public function run() {
        Log::write('info', 'LogTask has been executed.');
        return true;
    }
}

// Register the tasks with the shell
$scheduler = new SchedulerShell(new ConsoleIo(), new ConsoleOptionParser());
$scheduler->loadModel('Tasks');
$scheduler->Tasks->registerTask('log', LogTask::class);

// Run the scheduler with a task name
$scheduler->run(['task' => 'log']);
