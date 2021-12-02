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
        return [
            "message" => "Post"
        ];
    }
}
