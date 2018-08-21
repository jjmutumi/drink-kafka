<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


/** @var $newOrderValidator */
$newOrderValidator = $app->getContainer()->get('newOrderValidator');


$app->post('/api/orders', function (Request $request, Response $response, array $args) {
    $data = $request->getParsedBody();
    if ($newOrderValidator->validate($data)) {
        $this->newOrderTopic->produce(RD_KAFKA_PARTITION_UA, 0, $request->getBody()->getContents());
        $response = $response
                        ->withStatus(200)
                        ->withJson(["message" => "OK"]);
    } else {
        $errors = $newOrderValidator->getMessages();
        $response = $response
                        ->withStatus(400)
                        ->withJson(["message" => $errors]);
    }
    return $response;
});
