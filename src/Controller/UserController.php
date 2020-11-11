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
        $errors; 
        // setting minDate and maxDate for input date 
        $minDate = new \DateTime();
        $maxDate = clone $minDate;
        $minDate = $minDate->modify('+ 1 day')->format('Y-m-d');
        $maxDate = $maxDate->modify('+ 1 year')->format('Y-m-d');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Checking for, and displaying errors 
            if (empty($_POST['arrival'])) { 
                $errors = "Veuillez entrer une date d'arrivée"; 
                return $this->twig->render('Page/booking.html.twig', ['post' => $_POST, 'minDate' => $minDate, 'maxDate' => $maxDate, 'errors' => $errors]);

            }elseif (empty($_POST['departure'])) {
                $errors = "Veuillez entrer une date de départ";
                return $this->twig->render('Page/booking.html.twig', ['post' => $_POST, 'minDate' => $minDate, 'maxDate' => $maxDate, 'errors' => $errors]);

            }elseif (empty($_POST['roomSelect'])) {
                $errors = "Veuillez choisir une chambre";
                return $this->twig->render('Page/booking.html.twig', ['post' => $_POST, 'minDate' => $minDate, 'maxDate' => $maxDate, 'errors' => $errors]);

            }elseif (empty($_POST['guestSelect'])) {
                $errors = "Veuillez sélectionner le nombre d'adultes";
                return $this->twig->render('Page/booking.html.twig', ['post' => $_POST, 'minDate' => $minDate, 'maxDate' => $maxDate, 'errors' => $errors]);

            }elseif (empty($_POST['childGuestSelect'])) {
                $errors = "Veuillez sélectionner le nombre d'enfants";
                return $this->twig->render('Page/booking.html.twig', ['post' => $_POST, 'minDate' => $minDate, 'maxDate' => $maxDate, 'errors' => $errors]);

            } else {
            //reverse date to please french people
            $_POST['arrival'] = \App\Model\BookingManager::reverseDate($_POST['arrival']);
            $_POST['departure'] = \App\Model\BookingManager::reverseDate($_POST['departure']);
            return $this->twig->render('User/summary.html.twig', ['post' => $_POST, 'errors' => $errors]);
            }
        }
    }

    public function checkout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->twig->render('User/checkout.html.twig', ['post' => $_POST]);
        }
    }
}
