<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MusiquesRepository;
use App\Entity\Musiques;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(MusiquesRepository $musiquesRepository )
    {
        return $this->render('main/index.html.twig');
    }

    /**
     * @Route("/listsound", name="listsound")
     */
    public function listsound( MusiquesRepository $musiquesRepository )
    {
        $listmusique = $musiquesRepository->findId();
        return $this->json($listmusique);
        //return $this->render('main/index.html.twig');
    }

    /**
     * @Route("/onemusique/{id}", name="onemusique", methods={"GET"})
     */
    public function onemusique( MusiquesRepository $musiquesRepository, Request $request )
    {
        $id = $request->get('id');
        $onemusique = $musiquesRepository->findOneBy(['id' => $id]);
        return $this->json($onemusique);
        //return $this->render('main/index.html.twig');
    }
}
