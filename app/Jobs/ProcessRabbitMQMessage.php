<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ProcessRabbitMQMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 60 * 60; // 1 hour
    private Carbon $startedAt;

    public function handle(): void
    {
        $connection = new AMQPStreamConnection (
            host: config("rabbitmq.host"),
            port: config("rabbitmq.port"),
            user: config("rabbitmq.user"),
            password: config("rabbitmq.password"),
            vhost: config("rabbitmq.vhost"),
            connection_timeout: config("rabbitmq.options.connection_timeout"),
            read_write_timeout: config("rabbitmq.options.read_write_timeout"),
            heartbeat: config("rabbitmq.options.heartbeat"),
            channel_rpc_timeout: config("rabbitmq.options.channel_rpc_timeout")
        );

        $channel = $connection->channel();

        $channel->basic_consume('TestMardani', '', false, false, false, false, function (AMQPMessage $message) {
            $this->processMessage($message);
            $message->ack();
        });

        $this->startedAt = now();

        while ($channel->is_consuming()) {
            if ($this->isTimeoutReached()) {
                // These two steps are optional
                $this->cleanup();
                $this->notify();
                break;
            }

            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

    private function processMessage(AMQPMessage $message): void
    {
        dump($message->body);

    }

    private function cleanup(): void
    {
        // YOUR CODE HERE
    }

    private function notify(): void
    {
        // YOUR CODE HERE
    }

    private function isTimeoutReached(): bool
    {
        $elapsedTime = $this->startedAt->diffInSeconds(now());

        // Adds 1 minute from the elapse time, so you have time to perform cleanup and notify if necessary.
        // This value is arbitrary and can be changed according to your needs.
        $elapsedTime += 60;

        return $elapsedTime >= $this->timeout;
    }
}
