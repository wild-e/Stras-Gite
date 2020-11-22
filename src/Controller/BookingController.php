<?php

namespace App\Controller;
use App\Model\UserManager;


class BookingController extends AbstractController
{

    public function booking()
    {
        // setting minDate and maxDate for input date
        $minDate = \App\Service\TimeSetter::setDate('+ 3 days');
        $maxDate = \App\Service\TimeSetter::setDate('+ 1 year');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Variable to display error
            $error = "";

            // Checking time difference between arrival and departure
            $arrival = new \DateTime($_POST['arrival']);
            $departure = new \DateTime($_POST['departure']);
            $nightsNumber = $arrival->diff($departure)->format('%d');

            // Checking for, and displaying error
            if (empty($_POST['arrival'])) {
                $error = "Veuillez entrer une date d'arrivée !";
                return $this->twig->render(
                    'Booking/booking.html.twig',
                    ['post' => $_POST, 'minDate' => $minDate, 'maxDate' => $maxDate, 'error' => $error]
                );
            } elseif (empty($_POST['departure'])) {
                $error = "Veuillez entrer une date de départ !";
                return $this->twig->render(
                    'Booking/booking.html.twig',
                    ['post' => $_POST, 'minDate' => $minDate, 'maxDate' => $maxDate, 'error' => $error]
                );
            } elseif ($nightsNumber < 3) {
                $error = "Réservation minimum de 3 nuits !";
                return $this->twig->render(
                    'Booking/booking.html.twig',
                    ['post' => $_POST, 'minDate' => $minDate, 'maxDate' => $maxDate, 'error' => $error]
                );
            } elseif ($arrival > $departure) {
                $error = "Attention ! Il doit y avoir une erreur dans les dates";
                return $this->twig->render(
                    'Booking/booking.html.twig',
                    ['post' => $_POST, 'minDate' => $minDate, 'maxDate' => $maxDate, 'error' => $error]
                );
            } elseif (empty($_POST['roomSelect'])) {
                $error = "Veuillez choisir une chambre !";
                return $this->twig->render(
                    'Booking/booking.html.twig',
                    ['post' => $_POST, 'minDate' => $minDate, 'maxDate' => $maxDate, 'error' => $error]
                );
            } elseif (empty($_POST['guestSelect'])) {
                $error = "Veuillez sélectionner le nombre d'adultes !";
                return $this->twig->render(
                    'Booking/booking.html.twig',
                    ['post' => $_POST, 'minDate' => $minDate, 'maxDate' => $maxDate, 'error' => $error]
                );
            } elseif (empty($_POST['childGuestSelect'])) {
                $error = "Veuillez sélectionner le nombre d'enfants !";
                return $this->twig->render(
                    'Booking/booking.html.twig',
                    ['post' => $_POST, 'minDate' => $minDate, 'maxDate' => $maxDate, 'error' => $error]
                );
            } else {
            //Reversing date format to please french people UX/UI
                $_POST['arrival'] = $arrival->format('d-m-Y');
                $_POST['departure'] = $departure->format('d-m-Y');
            //Sending number of nights to insert later in DB
                return $this->twig->render(
                    'Booking/summary.html.twig',
                    ['post' => $_POST, 'error' => $error, 'nightsNumber' => $nightsNumber]
                );
            }
        }

    // For first show of the booking Page
    return $this->twig->render('Booking/booking.html.twig', ['minDate' => $minDate, 'maxDate' => $maxDate]);
}

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Variable to display error
            $error = "";

            if (empty($_POST["lastname"])) {
                $error = "Merci de donner votre nom";
                return $this->twig->render('Booking/summary.html.twig', ['post' => $_POST, 'error' => $error]);

            } elseif (empty($_POST["firstname"])) {
                $error = "Merci de donner votre prénom";
                return $this->twig->render('Booking/summary.html.twig', ['post' => $_POST, 'error' => $error]);

            } elseif (!preg_match("^[0-9]$/", $_POST['phoneNumber'])) {
                $error = "Veuillez donner votre numéro de télèphone. Celui-ci doit être sans espaces";
                return $this->twig->render('Booking/summary.html.twig', ['post' => $_POST, 'error' => $error]);

            } elseif (empty($_POST["email"])) {
                $error = "Veuillez donner votre email";
                return $this->twig->render('Booking/summary.html.twig', ['post' => $_POST, 'error' => $error]);
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "Format d'email invalide";
                return $this->twig->render('Booking/summary.html.twig', ['post' => $_POST, 'error' => $error]);

            } elseif (empty($_POST['password']) || empty($_POST['passwordCheck']) ||
             $_POST['password'] <> $_POST['passwordCheck']){
                $error = "Veuillez donner un mot de passe et le répeter";
                return $this->twig->render('Booking/summary.html.twig', ['post' => $_POST, 'error' => $error]);
            } elseif (!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',
             $_POST['password'])){
                $error = "Le mot de passe doit posséder au moins 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial (@#-_$%^&+=§!?).
                 Sa longueur doit être comprise entre 8 et 20.";
                 return $this->twig->render('Booking/summary.html.twig', ['post' => $_POST, 'error' => $error]);

            } else {

                $userManager = new UserManager();
                $userInfo =
                [
                    'firstname' => trim(ucfirst($_POST['firstname'])),
                    'lastname' => trim(ucfirst($_POST['lastname'])),
                    'email' => trim($_POST['email']),
                    'phoneNumber' => trim($_POST['phoneNumber']),
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
                ];
                $registration = $userManager->register($userInfo);

                $_POST['firstname'] = trim(ucfirst($_POST['firstname']));
                $_POST['lastname'] = trim(ucfirst($_POST['lastname']));

            return $this->twig->render('Booking/checkout.html.twig', ['post' => $_POST]);
            }
        }
    }
}
