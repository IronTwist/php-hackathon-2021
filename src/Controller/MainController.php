<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render("home/index.html.twig");
    }

    /**
     * @Route("/booking", name="booking")
     * @param Request $request
     * @return Response
     */
    public function bookingId(Request $request){
        dump($request); 
        $name = $request->get('name');
        return $this->render("home/booking.html.twig", [
            'name' => $name
        ]);
    }

}

