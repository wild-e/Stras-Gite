<?php

namespace App\Service;

class VerifyService
{
    public function check()
    {
        $errors = '';
        if (empty($_POST["lastname"])) {
             $errors = "Veuillez entrer votre nom";
        } elseif (!preg_match("/[a-zA-Z0-9]+/", $_POST['lastname'])) {
             $errors = "Format invalide, uniquement des lettres";
        } elseif (empty($_POST["firstname"])) {
             $errors = "Veuillez entrer votre prénom";
        } elseif (!preg_match("/[a-zA-Z0-9]+/", $_POST['firstname'])) {
             $errors = "Format invalide, uniquement des lettres";
        } elseif (empty($_POST["email"])) {
             $errors = "Veuillez entrer votre e-mail";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
             $errors = "Format invalide";
        } elseif (empty($_POST["message"])) {
             $errors = "Vous n'avez pas laissé de message";
        } elseif (!preg_match("/[a-zA-Z0-9]+/", $_POST['message'])) {
             $errors = "Format invalide, uniquement des lettres";
        }
        return $errors;
    }
}
