<?php 

namespace System;

/**
 * Route
 * 
 *  WebAPI Route App
 */
class Route implements App
{
    public function __construct($root)
    {
        $this->root = $root;
        $this->isRoot();
    }

    protected $root;
    protected $args;
    protected $mode;

    public function getRoot()
    {
        return $this->root;
    }

    public function getArgments()
    {
        return $this->args;
    }

    public function isRoot()
    {
        $dir = dirname($_SERVER["SCRIPT_NAME"]);
        if ($dir == "/" || $dir == $_SERVER["DOCUMENT_ROOT"])
        {
            $this->mode = true;
        }
    }

    public function run()
    {
        if (!$this->mode)
        {
            preg_match('|' . dirname($_SERVER["SCRIPT_NAME"]) . '/([\w%/]*)|', $_SERVER["REQUEST_URI"], $matches);
        } else 
        {
            preg_match('|/([\w%/]*)|', $_SERVER["REQUEST_URI"], $matches);
        }

        $paths = explode('/', $matches[1]);
        $file = array_shift($paths);

        if (empty($file))
        {
            if (Gateway::Check())
            {
                Gateway::Show();
            } else {
                ErrorHandle::showGateway();
            }
            exit;
        }

        $this->args = [];
        foreach ($paths as $v)
        {
            if (!empty($v))
            {
                $this->args[] = urldecode($v);
            }
        }

        $file_path = $this->root . '/' . ucfirst($file) . 'Controller.php';

        try
        {
            if (!file_exists($file_path))
            {
                throw new \Exception("That request is not allowed");
            }
            else
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
                        if (!$response)
                        {
                            ErrorHandle::showNoResponse();
                            exit;
                        }

                        header("Content-Type: application/json; charset=utf-8", true, $response_code);
                        echo json_encode($response, JSON_UNESCAPED_UNICODE);
                    } else {
                        if ($response)
                        {
                            echo $response;
                        }
                    }
                } else {
                    throw new \Exception("That Method is not allowed");
                }
            }
        }
        catch (\Exception $e)
        {
            header("Content-Type: application/json; charset=utf-8", true, 403);
            echo json_encode([
                "error" => true,
                "message" => $e->getMessage(),
            ]);

            exit;
        }
    }
}
