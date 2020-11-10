<?php

namespace App\Controller;

class AdminController extends AbstractController
{
    public function showBooking()
    {
        if ($_SESSION['is_admin'] == 1) {
        return $this->twig->render('Admin/booking.html.twig');
        }
    }
}
