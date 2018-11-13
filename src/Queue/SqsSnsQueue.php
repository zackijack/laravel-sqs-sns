<?php

namespace Zackyjack\LaravelSqsSns\Queue;

use Aws\Sqs\SqsClient;
use Illuminate\Queue\SqsQueue;
use Zackyjack\LaravelSqsSns\Queue\Jobs\SqsSnsJob;

class SqsSnsQueue extends SqsQueue
{
    /**
     * The Job command routes by Subject
     *
     * @var array
     */
    protected $routes;

    /**
     * Create a new Amazon SQS SNS subscription queue instance
     *
     * @param \Aws\Sqs\SqsClient $sqs
     * @param string $default
     * @param string $prefix
     * @param array $routes
     */
    public function __construct(SqsClient $sqs, $default, $prefix = '', $routes = [])
    {
        parent::__construct($sqs, $default, $prefix);

        $this->routes = $routes;
    }

    /**
     * Pop the next job off of the queue.
     *
     * @param string $queue
     * @return \Joblocal\LaravelSqsSnsSubscriptionQueue\Queue\Jobs\SqsSnsJob
     */
    public function pop($queue = null)
    {
        $queue = $this->getQueue($queue);

        $response = $this->sqs->receiveMessage([
            'QueueUrl' => $queue,
            'AttributeNames' => ['ApproximateReceiveCount'],
        ]);

        if (is_array($response['Messages']) && count($response['Messages']) > 0) {
            return new SqsSnsJob(
                $this->container,
                $this->sqs,
                $response['Messages'][0],
                $this->connectionName,
                $queue,
                $this->routes
            );
        }
    }
}
