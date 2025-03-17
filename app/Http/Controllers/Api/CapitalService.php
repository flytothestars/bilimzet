<?php

namespace App\Http\Controllers\Api;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Exception;
use Illuminate\Support\Facades\Log;

class CapitalService
{
    private $connection;
    private $channel;
    private $exchange;
    private $routingKey;

    public function __construct($host, $port, $user, $password, $exchange, $routingKey)
    {
        try {
            $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
            $this->channel = $this->connection->channel();
            $this->exchange = $exchange;
            $this->routingKey = $routingKey;
        } catch (\Exception $e) {
            Log::error('Ошибка при подключении к AMQP: ' . $e->getMessage());
            return null;
        }
    }
               


    public function publish($data)
    {
        try {
            $message = new AMQPMessage(json_encode($data));
            Log::debug("capital publish AMQ");
            $this->channel->basic_publish($message, $this->exchange, $this->routingKey);
            Log::debug("capital publish success");
            return true;
        } catch (Exception $e) {
            Log::error('Failed to publish message to RabbitMQ: ' . $e->getMessage());
            return false;
        }
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
