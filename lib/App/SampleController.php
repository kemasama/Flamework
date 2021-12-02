<?php 

namespace App;

class SampleController extends Controller
{
    public function get()
    {
        return [
            "message" => "Hello, World!"
        ];
    }

    public function post()
    {
        global $app;

        $args = $app->getArgments();

        return [
            "message" => "Post",
            "requests" => $args,
        ];
    }
}
