<?php

namespace App\Http\Controllers;

use App\RabbitMQService;
use Illuminate\Http\Request;

class RabbitMQController extends Controller
{
    public function publishMessage(Request $request)
    {
        $message = $request->input('message');

        $rabbitMQService = new RabbitMQService();
        $rabbitMQService->publish($message);

        return response('Message published to RabbitMQ');
    }

    public function consumeMessage()
    {
        $rabbitMQService = new RabbitMQService();

        $callback = function ($msg) {
            echo "Received message: " . $msg->body . "\n";
        };

        $rabbitMQService->consume($callback);
    }
}
