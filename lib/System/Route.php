<?php 

namespace System;

/**
 * Reference
 *  PHPだけでRESTAPIを再現してみた
 *  https://qiita.com/guchimina/items/9f351944ddaa33ba73b0
 */
class Route implements App
{
    public function __construct($root)
    {
        $this->root = $root;
    }

    protected $root;
    protected $args;

    public function getArgments()
    {
        return $this->args;
    }

    public function run()
    {
        preg_match('|' . dirname($_SERVER["SCRIPT_NAME"]) . '/([\w%/]*)|', $_SERVER["REQUEST_URI"], $matches);

        $paths = explode('/', $matches[1]);
        $file = array_shift($paths);

        $this->args = [];
        foreach ($paths as $v)
        {
            if (!empty($v))
            {
                $this->args[] = $v;
            }
        }

        $file_path = $this->root . '/' . $file . 'Controller.php';

        if (!file_exists($file_path))
        {
            http_response_code(404);
        }
        else
        {
            try
            {
                //require_once $file_path;

                $class_name = "App\\" . ucfirst($file) . "Controller";
                $method_name = strtolower($_SERVER["REQUEST_METHOD"]);

                if (method_exists($class_name, $method_name)) {
                    $object = new $class_name();

                    $response = $object->$method_name(...$paths);
                    $response_code = $object->code ?? 200;
                    if (!empty($object->origin)) {
                        header(sprintf("Access-Control-Allow-Origin: %s", $object->origin));
                    }

                    if ($object->enableJson) {
                        header("Content-Type: application/json; charset=utf-8", true, $response_code);
                        echo json_encode($response);
                    } else {
                        echo $response;
                    }
                } else {
                    throw new \Exception(Error::METHOD_NOT_FOUND);
                }
            } 
            catch (\Exception $e)
            {
                header("Content-Type: application/json; charset=utf-8", true, 500);
                echo json_encode([
                    "error" => true,
                    "message" => $e->getMessage(),
                ]);

                exit;
            }
        }
    }
}
