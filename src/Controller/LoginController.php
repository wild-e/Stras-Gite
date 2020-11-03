<?php

namespace App\Controller;
use App\Model\UserManager;

class LoginController extends AbstractController
{
    public function login()
    {
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $userManager = new UserManager();
            $user = 
                [
                    'email' => $_POST['email'],
                    'password' => $_POST['password']
                ];
            $userManager->login($user);

        }
        return $this->twig->render('Login/login.html.twig');
    }
}