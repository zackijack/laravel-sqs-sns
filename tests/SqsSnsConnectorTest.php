<?php

namespace Zackyjack\LaravelSqsSns\Tests;

use PHPUnit\Framework\TestCase;
use Zackyjack\LaravelSqsSns\Queue\Connectors\SqsSnsConnector;
use Zackyjack\LaravelSqsSns\Queue\SqsSnsQueue;

class SqsSnsConnectorTest extends TestCase
{
    public function testCanInstantiateConnector()
    {
        $connector = new SqsSnsConnector();
        $this->assertInstanceOf(SqsSnsConnector::class, $connector);
    }

    public function testCanConnectToQueue()
    {
        $connector = new SqsSnsConnector();
        $queue = $connector->connect([
            'key' => 'dummy_key',
            'secret' => 'dummy_secret',
            'region' => 'us-west-2',
            'queue' => '',
        ]);

        $this->assertInstanceOf(SqsSnsQueue::class, $queue);
    }
}
