<?php
// 代码生成时间: 2025-09-18 16:46:17
// System Performance Monitor using PHP and CAKEPHP Framework

// Load CakePHP's autoloader
require '/var/www/html/cakephp/lib/Cake/Console/cake.php';

// Use CakePHP's console class to handle CLI requests
use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;

class SystemPerformanceMonitorShell extends Shell {

    public function main() {
        // Display a welcome message
        $this->out('System Performance Monitor Tool');
        $this->out('=====================================');

        // Ask the user for the type of performance data they want to monitor
        $type = $this->in('Enter the type of performance data to monitor (CPU, Memory, Disk):', ['CPU', 'Memory', 'Disk'], 'CPU');

        // Call the appropriate method based on user input
        switch ($type) {
            case 'CPU':
                $this->monitorCPU();
                break;
            case 'Memory':
                $this->monitorMemory();
                break;
            case 'Disk':
                $this->monitorDisk();
                break;
            default:
                $this->out('Invalid type selected.');
                break;
        }
    }

    // Monitor CPU usage
    private function monitorCPU() {
        // Fetch CPU usage
        $cpuUsage = shell_exec('top -bn1 | grep "Cpu(s)" | sed "s/.*, *\([0-9.]*\)%* id.*/\1/;s/.*, *\([0-9.]*\)%* wa.*/\1/"');

        // Display CPU usage
        $this->out("Current CPU Usage: {$cpuUsage}%");
    }

    // Monitor Memory usage
    private function monitorMemory() {
        // Fetch Memory usage
        $memInfo = file_get_contents('/proc/meminfo');
        $memInfoArray = preg_split('/\
/', $memInfo);
        $memTotal = 0;
        $memFree = 0;
        foreach ($memInfoArray as $line) {
            preg_match('/^MemTotal:\s+([0-9]+)\skB$/', $line, $matches);
            $memTotal = $matches[1];
            preg_match('/^MemFree:\s+([0-9]+)\skB$/', $line, $matches);
            $memFree = $matches[1];
        }

        // Calculate Memory usage
        $memUsage = ($memTotal - $memFree) / $memTotal * 100;

        // Display Memory usage
        $this->out("Current Memory Usage: {$memUsage}%");
    }

    // Monitor Disk usage
    private function monitorDisk() {
        // Fetch Disk usage
        $diskUsage = shell_exec('df -h | grep 