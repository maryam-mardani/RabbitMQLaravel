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


        // Declare a queue - durable is ture
        $channel->queue_declare('TestMardani', false, true, false, false);

        // mark messages as persistent (save the message to disk)
        $properties = ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT];
        $messageBody = 'salam';
        $message = new AMQPMessage($messageBody,$properties);


        //don't dispatch a new message to a worker until it has processed and acknowledged the previous one
        //$channel->basic_qos(null, 1, false);

        //Declare a «fanout» exchange (exchange types =  direct, topic, headers,fanout)
        //fanout: broadcasts all the messages (for logging system)
        //$channel->exchange_declare('logs', 'fanout', false, false, false);
        //$channel->basic_publish($message, 'logs', 'TestMardani');

        // Publish the message to the queue (default exchange)
        $channel->basic_publish($message, '', 'TestMardani');

        // Close the channel and connection
        $channel->close();
        $connection->close();
    }
}
