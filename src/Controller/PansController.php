<?php

namespace App\Controller;

use App\Entity\Pan;
use App\Form\PanType;
use App\Repository\PanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PansController extends AbstractController
{
    /**
     * @Route("/", name="app-home", methods="GET")
     */
    public function index(PanRepository $panRepository): Response
    {
        $pans = $panRepository->findBy([], ['createdAt' =>'DESC']);
        return $this->render('pans/index.html.twig', compact('pans'));
    }

    /**
     * @Route("/pans/{id<[0-9]+>}", name="app-pans-show", methods="GET")
     */
    public function show(Pan $pan): Response
    {
        return $this->render('pans/show.html.twig', compact('pan'));
    }

    /**
     * @Route("/pans/create", name="app-pans-create", methods="GET|POST")
     */
    public function create(Request $request,EntityManagerInterface $em): Response
    {

        $pan = new Pan;
       $form = $this->createForm(PanType::class, $pan);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($pan);
            $em->flush();
            return $this->redirectToRoute('app-home');
        }
        return $this->render('pans/create.html.twig', ['form'=> $form->createView()]);
    }

    /**
     * @Route("/pans/{id<[0-9]+>}/edit", name="app-pans-edit", methods="GET|PUT")
     */
    public function edit(Pan $pan,Request $request,EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PanType::class, $pan, ['method'=>'PUT']);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            return $this->redirectToRoute('app-home');
        }
        return $this->render('pans/edit.html.twig', 
        ['pan'=> $pan,
        'form'=> $form->createView()]);
    }

       /**
     * @Route("/pans/{id<[0-9]+>}", name="app-pans-delete", methods="DELETE")
     */
    public function delete(Request $request,Pan $pan,EntityManagerInterface $em): Response
    {
        $submittedToken = $request->request->get('csrf_token');

        if($this->isCsrfTokenValid('pan_deletion' . $pan->getId(), $submittedToken)){
            $em->remove($pan);
            $em->flush();
        }
 
        return $this->redirectToRoute('app-home');
    }
}
