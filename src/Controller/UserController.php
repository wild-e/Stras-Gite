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

    public function summary()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->twig->render('User/summary.html.twig', ['post' => $_POST]);
        }
    }

    public function checkout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->twig->render('User/checkout.html.twig', ['post' => $_POST]);
        }
    }
}
