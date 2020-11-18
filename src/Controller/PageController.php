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


    public function luxe()
    {
        return $this->twig->render('Page/luxe.html.twig');
    }

    public function standard()
    {
        return $this->twig->render('Page/standard.html.twig');
    }

    public function suite()
    {
        return $this->twig->render('Page/suite.html.twig');
    }

    public function contact()
    {
        return $this->twig->render('Page/contact.html.twig');
    }

    public function booking()
    {
        // setting minDate and maxDate for input date
        $minDate = \App\Model\BookingManager::setDate('+ 3 days');
        $maxDate = \App\Model\BookingManager::setDate('+ 1 year');
        return $this->twig->render('Page/booking.html.twig', ['minDate' => $minDate, 'maxDate' => $maxDate]);
    }
}
