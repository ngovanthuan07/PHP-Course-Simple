<?php

namespace app\controller;

use app\core\Application;
use app\core\Controller;
use app\core\middleware\AuthMiddleware;
use app\core\Request;
use app\model\User;

class SiteController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['contact']));
    }

    public function home() {
        $this->setLayout('auth');
        return $this->render('home');
    }

    public function contact() {
        $params = [
            'name'=> 'Thuan',
        ];
        return $this->render('contact', $params);
    }

    public function handleContact(Request $request) {


        return 'Handling submitted data';
    }
}