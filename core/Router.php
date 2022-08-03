<?php
namespace app\core;

use app\core\exception\NotFoundException;
use app\utils\ConstantUtil;


class Router
{
    public Request $req;
    public Response $resp;
    protected array $routers = array();

    public function get($path, $callback) {
        $this->routers['get'][$path] = $callback;
        return $this;
    }

    public function post($path, $callback) {
        $this->routers['post'][$path] = $callback;
        return $this;
    }

    public function __construct(Request $req, Response $resp)
    {
        $this->req = $req;
        $this->resp = $resp;
    }

    public function resolve() {

        $method = $this->req->method();
        $path = $this->req->getPath();

        $callback = $this->routers[$method][$path] ?? false;

        if($callback === false) {
            Application::$app ->resp->setStatusCode(404);
            throw new NotFoundException();
        }
        if(is_string($callback)) {
            print_r(Application::$app->view->renderView($callback));
            exit;
        }
        if(is_array($callback)) {
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;
            foreach ($controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }
        }
        //print_r(call_user_func($callback));
        print_r(call_user_func($callback, $this->req, $this->resp));
        exit;
    }

}