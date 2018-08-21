<?php
// DIC configuration

$container = $app->getContainer();

// kafka producer
$container['kafkaProducer'] = function ($c) {
    $rk = new \RdKafka\Producer();

    $settings = $c->get('settings')['kafka'];
    $rk->setLogLevel($settings['log_level']);
    $rk->addBrokers($settings['brokers']);
    return $rk;
};

// kafka NewOrder topic
$container['newOrderTopic'] = function ($c) {
    return $c->get('kafkaProducer')->newTopic("NewOrder");
};
