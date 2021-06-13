<?php

namespace App\Controller;

use App\Entity\Episode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping":{"id":"id"}})
     * @return Response
     */
    public function show(Program $program) : Response
    {       
        if (!$program){
            throw $this->createNotFoundException('No programm found in programm\'s table.');
        }    
        return $this->render('program/show.html.twig', ['program' => $program]);
    }


    /**
     * @Route ("/{program_id}/season/{season_id}", methods={"GET"}, name="season_show")     
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping":{"program_id":"id"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping":{"season_id":"id"}})
     * @return Reponse
     */        
    public function showSeason(Program $program, Season $season): Response
    {  
            $episodes=$this->getDoctrine()
            ->getRepository(Episode::class)
            ->findOneBy(['season' =>$season]);

        return $this->render("program/season_show.html.twig", ['program' => $program,"season" => $season,"episodes" =>$episodes]);
    }

    /**
     * @Route("/{program_id}/season/{season_id}/episode/{episode_id}", methods={"GET"}, name="episode_show")
     * @ParamConverter("program",class="App\Entity\Program", options={"mapping":{"program_id" = "id"}})
     * @ParamConverter("season",class="App\Entity\Season", options={"mapping":{"season_id" = "id"}})
     * @ParamConverter("episode",class="App\Entity\Episode", options={"mapping":{"episode_id" = "id"}})
     */
    public function showEpisode(Program $program, Season $season, Episode $episode) : Response
    {
        return $this->render("program/episode_show.html.twig", ['program' => $program,"season" =>$season,"episode"=> $episode]);
    }

}

