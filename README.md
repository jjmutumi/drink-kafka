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
