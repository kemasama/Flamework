
# FlameWork

## What this

Useful, fast, simple WebAPI Framework.

## How to use

Make your controller and request, that's it

### Example

Request

    GET http://localhost/Sample/

Response

    ["message": "Hello, World!"]

Request

    POST http://localhost/Sample/

Response

    ["message": "Post"]

You can see its behavior by looking at "lib/App/SampleController.php"

## Develop

### How to get argments

    global $app;
    $app->getArgments();

### Want dump

    $this->enableJson = false;

You can echo, print.

### Block Access-Control-Allow-Origin

    $this->origin = "";

or edit Controller.php (lib/App/Controller.php)

    $this->origin = "";
