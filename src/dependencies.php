<?php
// DIC configuration

$container = $app->getContainer();

// kafka producer
$container['kafka'] = function ($c) {
    $rk = new \RdKafka\Producer();
    $rk->setLogLevel(LOG_DEBUG);
    $rk->addBrokers("10.0.0.1,10.0.0.2");
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};
