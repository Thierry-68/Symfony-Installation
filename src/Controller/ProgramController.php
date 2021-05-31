<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;

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

}

