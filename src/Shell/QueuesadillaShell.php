<?php
namespace App\Shell;

use Cake\Datasource\ConnectionManager;
use Josegonzalez\CakeQueuesadilla\Queue\Queue;
use Monitor\Error\SentryHandler;

class QueuesadillaShell extends \Josegonzalez\CakeQueuesadilla\Shell\QueuesadillaShell
{
    /**
     * Retrieves a queue worker
     *
     * @param \josegonzalez\Queuesadilla\Engine\Base $engine engine to run
     * @param \Psr\Log\LoggerInterface $logger logger
     * @return \josegonzalez\Queuesadilla\Worker\Base
     */
    public function getWorker($engine, $logger)
    {
        $worker = parent::getWorker($engine, $logger);
        $worker->attachListener('Worker.job.exception', function ($event) {
            $exception = $event->data['exception'];
            $exception->job = $event->data['job'];
            $sentryHandler = new SentryHandler();
            $sentryHandler->handle($exception);
        });
        $worker->attachListener('Worker.job.success', function ($event) {
            ConnectionManager::get('default')->disconnect();
        });
        $worker->attachListener('Worker.job.failure', function ($event) {
            $failedJob = $event->data['job'];
            $failedItem = $failedJob->item();
            $options = [
                'queue' => 'failed',
                'failedJob' => $failedJob
            ];
            Queue::push($failedItem['class'], $failedJob->data(), $options);
            ConnectionManager::get('default')->disconnect();
        });

        return $worker;
    }
}
