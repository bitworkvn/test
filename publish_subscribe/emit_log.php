<?php
require_once '../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$exchange = 'logs';
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->exchange_declare($exchange, 'fanout', false, false, false);

$data = implode(' ', array_slice($argv, 1));
if(empty($data)) $data = "info: Hello World!";

$msg = new AMQPMessage($data);
$channel->basic_publish($msg, $exchange);
echo " [x] Sent ", $data, "\n";

$channel->close();
$connection->close();