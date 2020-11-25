<?php

namespace App\Controller;

use App\Repository\PanRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PansController extends AbstractController
{
    /**
     * @Route("/", name="app-home")
     */
    public function index(PanRepository $panRepository): Response
    {
        $pans = $panRepository->findAll();
        return $this->render('pans/index.html.twig', compact('pans'));
    }
}
