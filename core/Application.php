<?php

namespace app\core;

use app\config\CoreConfig;
use app\utils\ConstantUtil;

class Application
{
    public string $layout = 'main';
    public static string $ROOT_DIR;
    public static Application $app;
    public string $userClass;
    public Router $router;
    public Request $req;
    public Response $resp;
    public Database $db;
    public Session $session;

    public View $view;
    public ?DbModel $user;
    public ?Controller $controller = null;

    public function __construct() {
        $this->userClass = CoreConfig::config()['userClass'];
        self::$ROOT_DIR = dirname(__DIR__);
        self::$app = $this;
        $this->req = new Request();
        $this->resp = new Response();
        $this->router = new Router($this->req, $this->resp);
        $this->view = new View();
        $this->session = new Session();
        $this->db = new Database(CoreConfig::config()['db']);

        $primaryKeyValue = $this->session->get('user');
        if($primaryKeyValue){
            $primaryKey = (new $this->userClass) -> primaryKey();
            $this->user = (new $this->userClass) -> findOne([$primaryKeyValue => $primaryKeyValue]);
        } else{
            $this->user = null;
        }
    }

    public function run() {
        try {
            $this->router->resolve();
        } catch (\Exception $exception) {
            echo $this->view->renderView('error/_error', [
                'exception' => $exception
            ]);
        }
    }


    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return self::$app->user ?? false;
    }

}