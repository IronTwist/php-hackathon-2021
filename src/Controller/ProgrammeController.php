<?php

namespace App\Controller;

use App\Entity\Programme;
use App\Repository\ProgrammeRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/programme', name: 'programme.')]
class ProgrammeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgrammeRepository $programmeRepository): Response
    {   
        $programmes = $programmeRepository->findAll();
        dump($programmes);
        return $this->render('programme/index.html.twig', [
            'programmes' => $programmes,
        ]);
    }

    /**
     * @Route("/create",name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request){
        $programme = new Programme();
        $programme->setName("Karate");
        $programme->setRoom(2);
        $programme->setMaxParticipants(10);
        $programme->setStartProgramme(new DateTime("2021-04-18 17:20:03"));
        $programme->setEndProgramme(new DateTime("2021-04-18 18:20:03"));

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($programme);
        $entityManager->flush();

        return new Response('New programme added');
    }
}
