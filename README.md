# Test Drink Order REST API with Kafka and Slim Framework 3

Simple REST API to take orders of drinks then stream to Kafka brokers for processing.

## Install the Application

Clone this repository:

	git clone https://github.com/jjmutumi/drink-kafka.git

Run this command from the directory in which you clone:

	cd drink-kafka
    composer update

* Point your virtual host document root to your new application's `public/` directory.

## Running the Application

To run the application in development, you can run these commands:

	composer start

## Running the Tests

Run this command in the application directory to run the test suite

	composer test

## The Requirements

POST

/api/orders

| Variable      | Type                  | Description                               |
| ------------- | --------------------- | ----------------------------------------- |
| name          | string                | Name of the person ordering the drink     |
| room          | string                | Name of the room the person is in         |
| type          | string                | Type of drink                             |
| milk          | boolean               | Does the person want milk or not          |
| sugar         | integer               | Number of sugars                          |

The api does a very basic validation of the data and then passes an event containing the data into a kafka topic of `NewOrder`.