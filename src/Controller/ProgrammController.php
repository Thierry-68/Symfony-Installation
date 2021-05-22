<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgrammController extends AbstractController
{
    /**
     * @Route("/programs", name="programs_index")
     */
    public function index(): Response
    {
        return new Response('<html><body>The new Wild Series Index</body><hml>');
    } 
}