<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use App\Repository\ProgrammeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/booking', name: 'booking.')]
class BookingController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }

    /**
     * @Route("/create/{id}", name="create")
     * @return Response
     */
    public function create($id, ProgrammeRepository $programmeRepository){
        $booking = new Booking();
        $user = $this->getUser();
        $userId = $user->getId();

        $programme = $programmeRepository->find($id);
        $programmeId = $programme->getId();
        
        $booking->setUserId($userId);
        $booking->setProgrammeId($programmeId);
        
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($booking);
        $entityManager->flush();

        
        return $this->render("booking/index.html.twig", [
            'programme' => $programme,
            'booking' => $booking
        ]);
    }

     /** 
     * @Route("/show", name="show")
     * @return Response
     */
    public function show(BookingRepository $bookingRepository, ProgrammeRepository $programmeRepository){

        $user = $this->getUser();
        $userId = $user->getId();

        $bookingsIds = $bookingRepository->findUserBookings($userId);
       
        $myProgrammes = [];

        foreach($bookingsIds as $bId){
            
            $id = $bId['programmeId'];

            array_push($myProgrammes,  $programmeRepository->find($id));
            
        }

        // dump($myProgrammes);

        return $this->render("booking/show.html.twig", [
            'myProgrammes' => $myProgrammes
        ]);
    }
}
