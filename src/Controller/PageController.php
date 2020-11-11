<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

class PageController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function activities()
    {
        return $this->twig->render('Page/activities.html.twig');
    }

    public function map()
    {
        return $this->twig->render('Page/map.html.twig');
    }

    public function chambre()
    {
        return $this->twig->render('Page/chambre.html.twig');
    }

    public function contact()
    {
        return $this->twig->render('Page/contact.html.twig');
    }

    public function booking()
    {
        // setting minDate and maxDate for input date 
        $minDate = new \DateTime();
        $maxDate = clone $minDate;
        $minDate = $minDate->modify('+ 1 day')->format('Y-m-d');
        $maxDate = $maxDate->modify('+ 1 year')->format('Y-m-d');
        return $this->twig->render('Page/booking.html.twig', ['minDate' => $minDate, 'maxDate' => $maxDate]);
    }
}
