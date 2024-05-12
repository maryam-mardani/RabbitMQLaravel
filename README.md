<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Install & Usage
- composer install
- php artisan serve
- php artisan tinker
- RabbitMQMessageProducer::dispatchSync(); // for produce a message
- ProcessRabbitMQMessage::dispatchSync(); // for fetch messages



## Install RabbitMQ on Windows
- Install Erlang: RabbitMQ requires a 64-bit supported version of Erlang for Windows to be installed.
- Install RabbitMQ: Download RabbitMQ windows installer from (https://www.rabbitmq.com/docs/install-windows)
- Open a cmd as administrator and go to the RabbitMQ directory (C:\Program Files\RabbitMQ Server\rabbitmq_server-3.13.2\sbin)
- Run rabbitmqctl.bat help (if returned the help documentation, means that installed as well)
- Enable Plugin: Run rabbitmq-plugins.bat enable rabbitmq_management
- Start Xampp apache or wamp or something else
- Open browser and go to this link: (http://localhost:15672/)
- if you don't be able to see RabbitMQ dashboard, you should doing next steps:
    -  Run rabbitmq_service remove
    -  Run rabbitmq_service install
    -  Reinstall RabbitMQ installer
      



