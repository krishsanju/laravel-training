<?php

//KNOWING THE DEPENDENCIES
//THOWING ERROR


use App\PhpUnitTesting\Queue;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Depends;

final class QueueTest extends TestCase
{

    private Queue $queue;
    public function setUp(): void
    {
        $this->queue = new Queue();
    }

    public function tearDown(): void
    {
        //used when to unset any variables which are used in the queue
    }
    public function testNewQueueIsEmpty(): void
    {
        // $queue = new Queue();
        $this->assertSame(0, $this->queue->getSize());
        // return $queue;
    }

    // #[Depends('testNewQueueIsEmpty')]
    public function testPushAddsItem()
    {
        // $queue = new Queue();
        $this->queue->push("an item");
        $this->assertSame(1, $this->queue->getSize());
        // return $queue;
    }

    // #[Depends('testPushAddsItem')]
    public function testPopRemovesAndReturnItem(): void
    {
        // $queue = new Queue();
        $this->queue->push("two item");
        $this->assertSame('two item', $this->queue->pop());
        $this->assertSame(0, $this->queue->getSize());
    }

    public function testAnItemIsRemovedFromTheFrontOfTheQueue()
    {
        $this->queue->push('first');
        $this->queue->push('Second');
        $this->assertSame('first', $this->queue->pop());
    }

    // public function testPopThrowsExceptionWhenQueueIsEmtpy(): void
    // {
    //     $this->expectException(\UnderflowException::class);
    //     $this->expectExceptionMessage('Exception vachindi ma');
    //     $this->queue->pop();
    // }
}