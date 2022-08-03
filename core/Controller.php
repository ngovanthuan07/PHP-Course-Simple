<?php

namespace app\core;

use app\core\middleware\BaseMiddleware;

class Controller
{
    public string $layout = 'main';
    public string $action = '';
    protected array $middlewares = [];

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @param array $middlewares
     */
    public function setMiddlewares(array $middlewares): void
    {
        $this->middlewares = $middlewares;
    }

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function render($view, $params = []) {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }
}