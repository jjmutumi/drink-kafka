<?php

namespace Tests\Functional;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;


class OrderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Process the application given a request method and URI
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri the request URI
     * @param array|object|null $requestData the request data
     * @return \Slim\Http\Response
     */
    public function runApp($requestMethod, $requestUri, $requestData = null)
    {
        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'CONTENT_TYPE' => 'application/json',
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );

        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);

        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        // Set up a response object
        $response = new Response();

        // Use the application settings
        $settings = require __DIR__ . '/../src/settings.php';

        // Instantiate the application
        $app = new App($settings);

        // Set up dependencies
        require __DIR__ . '/../src/dependencies.php';

        // Register middleware
        require __DIR__ . '/../src/middleware.php';

        // Register routes
        require __DIR__ . '/../src/routes.php';

        // Process the application
        $response = $app->process($request, $response);

        // Return the response
        return $response;
    }

    public function testDrinkOrder()
    {
        $body = [
            "name" => "Mike Bywater",
            "room" => "Blue Sky",
            "type" => "coffee",
            "milk" => true,
            "sugar" => 2
        ];
        $response = $this->runApp("POST", "/api/orders", $body);
        $this->assertEquals(200, $response->getStatusCode());
        $response->getBody()->seek(0);
        $content = $response->getBody()->read(9046);
        $this->assertEquals('{"message":"OK"}', $content);
    }
}
