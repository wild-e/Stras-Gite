<?php

namespace App\Controller;
use App\Model\UserManager;
use App\Model\BookingManager;


class BookingController extends AbstractController
{

    public function booking()
    {
        // setting minDate and maxDate for input date
        $minDate = \App\Service\TimeSetter::setDate('+ 3 days');
        $maxDate = \App\Service\TimeSetter::setDate('+ 1 year');

        // Checking for, and displaying error after POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Variable to display error
            $error = "";

            // Checking time difference between arrival and departure
            $arrival = new \DateTime($_POST['arrival']);
            $departure = new \DateTime($_POST['departure']);
            $nightsNumber = $arrival->diff($departure)->format('%d');

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
                $displayArrival = $arrival->format('d-m-Y');
                $displayDeparture = $departure->format('d-m-Y');
            //Sending number of nights to insert later in DB
                return $this->twig->render('Booking/summary.html.twig', [
                    'post' => $_POST, 
                    'error' => $error, 
                    'nightsNumber' => $nightsNumber, 
                    'displayArrival' => $displayArrival, 
                    'displayDeparture' => $displayDeparture
                    ]);
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

            } elseif (!is_numeric($_POST['phoneNumber'])) {
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
                // Triming name for a nice display 
                $_POST['firstname'] = trim(ucfirst($_POST['firstname']));
                $_POST['lastname'] = trim(ucfirst($_POST['lastname']));

                // Inserting clients Info in DB
                $userManager = new UserManager();
                $userInfo =
                [
                    'firstname' => $_POST['firstname'],
                    'lastname' => $_POST['lastname'],
                    'email' => trim($_POST['email']),
                    'phoneNumber' => $_POST['phoneNumber'],
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
                ];
                $registration = $userManager->register($userInfo);

                // Check if User info were inserted, then insert booking info in DB 
                if($registration){

                    // Transforming room service choice into bool for inserting in DB
                    if ($_POST['roomServiceChoice'] === 50){
                        $_POST['roomServiceChoice'] === 1;
                    }else{
                        $_POST['roomServiceChoice'] === 0;
                    }

                    // Transforming child select choice into 0 for inserting in DB
                    if ($_POST['childGuestSelect'] == 'aucun'){
                        $_POST['childGuestSelect'] === 0;
                    }

                    $bookingManager = new BookingManager();
                    $bookingInfo =
                    [
                        'firstname' => $_POST['firstname'],
                        'lastname' => $_POST['lastname'],
                        'arrival' => $_POST['arrival'],
                        'departure' => $_POST['departure'],
                        'roomSelect' => $_POST['roomSelect'],
                        'guestSelect' => $_POST['guestSelect'],
                        'childGuestSelect' => $_POST['childGuestSelect'],
                        'nightsNumber' => $_POST['nightsNumber'],
                        'paidPrice' => $_POST['paidPrice'],
                        'roomServiceChoice' => $_POST['roomServiceChoice']
                    ];
                    $booking = $bookingManager->book($bookingInfo);
                    return $this->twig->render('Booking/checkout.html.twig', ['post' => $_POST, 'booking' => $booking]);

                }

            return $this->twig->render('Booking/checkout.html.twig', ['post' => $_POST]);
            }
        }
    }
}
