<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Programme;
use App\Form\ProgrammeType;
use App\Repository\BookingRepository;
use App\Repository\ProgrammeRepository;
use App\Service\ProgrammeService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Comparator\DateComparator;
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
       
        return $this->render('programme/index.html.twig', [
            'programmes' => $programmes,
        ]);
    }

    /**
     * @Route("/create",name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request, ProgrammeRepository $programmeRepository, ProgrammeService $programmeService){
        
        $programme = new Programme();
        
        $form = $this->createForm(ProgrammeType::class, $programme);

        $form->handleRequest($request);

        $form->getErrors();
        
        if ($form->isSubmitted() && $form->isValid()) { 

                //For start/end DateTime validation
                $data = $form->getData();
                $getRoomNumber = $data->getRoom();
                
                /** get list of all datetime records of a choosen room*/
                $datesListByRoom = $programmeRepository->findAllDatesOnRoom($getRoomNumber);
                
                $error = 0;

                foreach($datesListByRoom as $dateRoom){
                    // dump($dateRoom["end_programme"]); die;
                    
                    $start = $dateRoom["start_programme"];
                    $end = $dateRoom["end_programme"];
                    $checkNewStartDate = $data->getStartProgramme();
                    $checkNewEndDate = $data->getEndProgramme();

                    if($start <= $checkNewStartDate  && $checkNewStartDate <= $end){
                        $error = 1;
                    }

                    if($start <= $checkNewEndDate  && $checkNewEndDate <= $end){
                        $error = 1;
                    }

                    if($checkNewStartDate > $checkNewEndDate){
                        $error = 1;
                    }
                }

                // $programmeService->checkDateTimeIntersection($datesListByRoom, $data->getStartProgramme(), $data->getEndProgramme());

            $entityManager = $this->getDoctrine()->getManager();
            
            if ($error == 0) {
                $entityManager->persist($programme);
                $entityManager->flush();

                $this->addFlash("createSucces","New programme creted!");
            }else{
                $this->addFlash("createErrorDatetime","Check if dates are not intersecting other programme and try again!");
            }

    
            return $this->redirect($this->generateUrl("programme.index"));
        }

        return $this->render("programme/create.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /** 
     * @Route("/delete/{id}", name="delete")
     * @return Response
     */
    public function remove($id, ProgrammeRepository $programmeRepository, BookingRepository $bookingRepository){
        
        $programmeToDelete = $programmeRepository->find($id);
        $bookings = $bookingRepository->findAll();

        $entityManager = $this->getDoctrine()->getManager();

        foreach($bookings as $booking){
            if($booking->getProgrammeId() == $programmeToDelete->getId()){
                $entityManager->remove($booking);
            }
        }

        $entityManager->remove($programmeToDelete);

        $entityManager->flush();

        $this->addFlash("deleteSucces","Programme removed!");

        return $this->redirect($this->generateUrl("programme.index"));
    }

    /** 
     * @Route("/show/{id}", name="show")
     * @return Response
     */
    public function show($id, ProgrammeRepository $programmeRepository, BookingRepository $bookingRepository){
        $selectedProgrameId = $id;

        $programmeShow = $programmeRepository->find($id);

        //Find my registered programmes************************START
        $user = $this->getUser();
        $userId = $user->getId();

        $bookingsIds = $bookingRepository->findUserBookings($userId);
       
        $myProgrammes = [];

        foreach($bookingsIds as $bId){
            
            $id = $bId['programmeId'];

            array_push($myProgrammes,  $programmeRepository->find($id));
            
        }
        //Find my registered programmes************************END

        //Count places left ***********************************START
        $countOcupied = 0;
        $programmeForCount = $bookingRepository->findAllByProgrammeId($selectedProgrameId);
        
        foreach($programmeForCount as $programmefound){
            $countOcupied++;
        }
        //Count places left ***********************************END

        return $this->render("programme/show.html.twig", [
            'programme' => $programmeShow,
            'myProgrammes' => $myProgrammes,
            'ocupiedWithParticipants' => $countOcupied
        ]);
    }

}
