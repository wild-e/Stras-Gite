<?php

namespace App\Controller;

class UserController extends AbstractController
{
    public function showBooking()
    {
        if ($_SESSION['is_admin'] == 0) {
        return $this->twig->render('User/booking.html.twig');
        }
    }

    public function writeReview()
    {
        if ($_SESSION['is_admin'] == 0) {
        return $this->twig->render('User/writeReview.html.twig');
        }
    }
}
