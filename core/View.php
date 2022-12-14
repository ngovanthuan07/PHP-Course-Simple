<?php

namespace app\core;

class View
{
    public string $title = '';

    public function renderView($view, $params = []) {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function layoutContent() {
        $layout = Application::$app->layout;
        if(Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    public function renderOnlyView($view, $params) {
        // de rai cac phan tru trong mang
        // cach 1:
//        foreach ($params as $key=>$value) {
//            $$key = $value;
//        }
        // cach 2:
        extract($params);
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }

    public function renderContent($contentView) {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $contentView, $layoutContent);
    }
}