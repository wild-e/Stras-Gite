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
            $login = $userManager->login($user);

            if(is_array($login)){
                $_SESSION['email'] = $login['email'];
                $_SESSION['password'] = $login['password'];
                $_SESSION['firstname'] = $login['firstname'];
                // Rajouter toutes les données utilisaturs de la BDDD à récupérer
                header('Location:/');

            }else{
                header('Location:/Login/login');
            }
        }
        return $this->twig->render('Login/login.html.twig');
    }
}