<?php

namespace App\Controller;
use App\Model\BookingManager;


class AdminController extends AbstractController
{
    public function showBooking()
    {
        if ($_SESSION['is_admin'] == 1) {
            $bookingManager = new BookingManager();
            $bookingInfo = $bookingManager->selectAll();
            return $this->twig->render('Admin/booking.html.twig', ['bookingInfo' => $bookingInfo]);
        }
    }

    public function messageShow()
    {
        if ($_SESSION['is_admin'] == 1) {
            return $this->twig->render('Admin/messageShow.html.twig');
        }
    }
}
