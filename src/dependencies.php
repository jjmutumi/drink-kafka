<?php
/**
 *  DIC configuration
 */

use Respect\Validation\Validator as v;


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

// drink order validator
$container["newOrderValidator"] = function ($c) {
    return v::key("name", v::stringType())
            ->key("room", v::stringType())
            ->key("type", v::stringType())
            ->key("milk", v::boolType())
            ->key("sugar", v::intType()->min(0));
};
