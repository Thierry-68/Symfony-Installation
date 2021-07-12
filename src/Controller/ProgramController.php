<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Service\Slugify;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

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
     * @Route("/new",name="new")
     * @return Response A response instance
     */

    public function new (Request $request,MailerInterface $mailer, Slugify $slugify):Response
    {         
        $program=new Program();        
        $form=$this->createForm(ProgramType::class,$program);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager=$this->getDoctrine()->getManager();
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);
            $entityManager->persist($program);
            $entityManager->flush();
            $toFrom = $this->getParameter('mailer_from');
            $email = (new Email())
                ->from($toFrom)
                ->to('your_email@example.com')
                ->subject('Une nouvelle série vient d\'être publiée !')
                ->html($this->renderView('Program/newProgramEmail.html.twig',['program' => $program]));
            $mailer->send($email);
           return $this->redirectToRoute('program_index');
        }

        return $this->render("program/new.html.twig",["form"=>$form->createView()]);
    }    

     /**
     * Getting a programm by slug
     *  
     * @Route("/{slug}", methods={"GET"}, name="show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping":{"slug":"slug"}})
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
     * @Route ("/season/{slug}", methods={"GET"}, name="season_show") 
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping":{"slug":"slug"}})
     * @return Reponse
     */        
    public function showSeason(Season $season): Response
    {  
            $episodes=$this->getDoctrine()
            ->getRepository(Episode::class)
            ->findOneBy(['season' =>$season]);
            $program=$season->getProgram();

        return $this->render("program/season_show.html.twig", ['program' => $program,"season" => $season,"episodes" =>$episodes]);
    }

    // /**
    //  * @Route("/{program_id}/season/{season_id}/episode/{episode_id}", methods={"GET"}, name="episode_show")
    //  * @ParamConverter("program",class="App\Entity\Program", options={"mapping":{"program_id" = "id"}})
    //  * @ParamConverter("season",class="App\Entity\Season", options={"mapping":{"season_id" = "id"}})
    //  * @ParamConverter("episode",class="App\Entity\Episode", options={"mapping":{"episode_id" = "id"}})
    //  */
    // public function showEpisode(Program $program, Season $season, Episode $episode) : Response
    // {
    //     return $this->render("program/episode_show.html.twig", ['program' => $program,"season" =>$season,"episode"=> $episode]);
    // }

     /**
     * @Route("/episode/{slug}", methods={"GET"}, name="episode_show")
     * @ParamConverter("episode",class="App\Entity\Episode", options={"mapping":{"slug" = "slug"}})
     */
    public function showEpisode(Episode $episode) : Response
    {        
        $season=$episode->getSeason();
        $program=$season->getProgram();
        return $this->render("program/episode_show.html.twig", ['program' => $program,"season" =>$season,"episode"=> $episode]);
    }




}

