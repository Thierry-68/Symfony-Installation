<?php

namespace App\Controller;

use App\Entity\Episode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;
use Doctrine\ORM\Mapping\Id;

/**
 * @Route("/programs", name="program_")
 */
class ProgramController extends AbstractController
{
    /**
     * Show a rows from Program's entity
     * 
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
       $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();
        return $this->render('program/index.html.twig',
            ['programs' => $programs]
        );
    } 

     /**
     * Getting a programm by id
     *  
     * @Route("/{id}", methods={"GET"}, requirements={"id"="\d+"},  name="show")
     * @return Response
     */
    public function show(int $id) : Response
    {
        $program=$this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $id]);
        
        if (!$program){
            throw $this->createNotFoundException('No programm with id :'.$id.' found in programm\'s table.');
        }    
        return $this->render('program/show.html.twig', ['program' => $program]);
    }


    /**
     * @Route ("/{programId}/season/{seasonId}", methods={"GET"}, name="season_show")
     * @return Reponse
     */        
    public function showSeason(int $programId, int $seasonId): Response
    {
        $program=$this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id'=>$programId]);
         
            $season=$this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id'=>$seasonId]);

            $episodes=$this->getDoctrine()
            ->getRepository(Episode::class)
            ->findOneBy(['season' =>$season]);

        return $this->render("program/season_show.html.twig", ['program' => $program,"season" => $season,"episodes" =>$episodes]);
    }
}

