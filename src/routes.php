<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Exceptions\NestedValidationException;


/** @var \Respect\Validation\Validator $newOrderValidator */
$newOrderValidator = $app->getContainer()->get('newOrderValidator');


$app->post('/api/orders', function (Request $request, Response $response, array $args) use ($newOrderValidator)
{
    $data = $request->getParsedBody();
    try {
        $newOrderValidator->assert($data);

        /** @var \RdKafka\ProducerTopic $newOrderTopic */
        $newOrderTopic = $this->newOrderTopic;
        $newOrderTopic->produce(RD_KAFKA_PARTITION_UA, 0, json_encode($data));
        $response = $response
                        ->withStatus(200)
                        ->withJson(["message" => "OK"]);
    } catch(NestedValidationException $exception) {
        $errors = $exception->getMessages();
        $response = $response
                        ->withStatus(400)
                        ->withJson(["message" => $errors]);
    }
    return $response;
});
