<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQMessageProducer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // Setup connection
        $connection = new AMQPStreamConnection(
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

        // Declare a queue
        $channel->queue_declare('TestMardani', false, false, false, false);

        $messageBody = 'salam';
        $message = new AMQPMessage($messageBody);

        // Publish the message to the queue
        $channel->basic_publish($message, '', 'TestMardani');

        // Close the channel and connection
        $channel->close();
        $connection->close();
    }
}
