<?php

namespace app\controller;

use app\core\Application;
use app\core\Controller;
use app\core\middleware\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\model\LoginForm;
use app\model\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function login(Request $req, Response $resp) {
        $loginForm = new LoginForm();
        if($req->isPost()) {
            $loginForm->loadData($req->getBody());
            if($loginForm->validate() && $loginForm->login()) {
                $resp->redirect('/');
            } else {
                return $this->render('login', [
                    'model' => $loginForm,
                ]);
            }
        }
        return $this->render('login', [
            'model' => $loginForm,
        ]);
    }

    public function register(Request $req) {
        $user = new User();
        if($req->isPost()) {
            $user->loadData($req->getBody());
            if ($user->validate() && $user->save()) {
                Application::$app->resp->redirect('/');
            }
            return $this->render('register', [
                'model' => $user,
            ]);
        }
        return $this->render('register', [
            'model' => $user,
        ]);
    }

    public function logout(Request $req, Response $resp)
    {
        Application::$app->logout();
        $resp->redirect('/login');
    }

    public function profile()
    {
        return $this->render('profile');
    }

}