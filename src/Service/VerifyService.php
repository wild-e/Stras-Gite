<?php

namespace App\Service;

class VerifyService
{
    public function check($input)
    {
        if (empty($_POST["lastname"])) {
            return $errors = "Veuillez entrer votre nom";
        } elseif (!preg_match("/[a-zA-Z0-9]+/", $_POST['lastname'])) {
            return $errors = "Format invalide, uniquement des lettres";
        } elseif (empty($_POST["firstname"])) {
            return $errors = "Veuillez entrer votre prénom";
        } elseif (!preg_match("/[a-zA-Z0-9]+/", $_POST['firstname'])) {
            return $errors = "Format invalide, uniquement des lettres";
        } elseif (empty($_POST["email"])) {
            return $errors = "Veuillez entrer votre e-mail";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            return $errors = "Format invalide";
        } elseif (empty($_POST["message"])) {
            return $errors = "Vous n'avez pas laissé de message";
        } elseif (!preg_match("/[a-zA-Z0-9]+/", $_POST['message'])) {
            return $errors = "Format invalide, uniquement des lettres";
        }
    }
}
