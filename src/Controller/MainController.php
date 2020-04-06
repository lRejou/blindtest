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
     * @Route("/listsound/{diff}/{theme}", name="listsound", methods={"GET"})
     */
    public function listsound( MusiquesRepository $musiquesRepository, Request $request )
    {
        //Gestion de la difficulté
        $difficulte = $request->get('diff');
        $tabDiff = [0,0,0,0];
        if($difficulte >= 1000){ $tabDiff[3] = 1; $difficulte = $difficulte - 1000;}
        if($difficulte >= 100){ $tabDiff[2] = 1; $difficulte = $difficulte - 100;}
        if($difficulte >= 10){ $tabDiff[1] = 1; $difficulte = $difficulte - 10;}
        if($difficulte >= 1){ $tabDiff[0] = 1; $difficulte = $difficulte - 1;}

        //theme
        $theme = explode('!', $request->get('theme'));

        //Requete SQL
        $listmusique = $musiquesRepository->findId($tabDiff, $theme);

        //Retour du json
        return $this->json($listmusique);
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


    /**
     * @Route("/admin", name="admin", methods={"GET"})
     */
    public function admin( MusiquesRepository $musiquesRepository)
    {
        $musiques = $musiquesRepository->findAll();
        return $this->render('admin/index.html.twig' , ["musiques" => $musiques]);
    }

    /**
     * @Route("/admin/add", name="add", methods={"GET"})
     */
    public function add()
    {

        return $this->render('admin/add.html.twig');
    }

    /**
     * @Route("/admin/ajaxadd/{titre}/{oeuvre}/{desc}/{timer}/{diff}/{annee}/{idvideo}/{theme}" , name="ajaxadd", methods={"GET"})
     */
    public function ajaxadd(MusiquesRepository $musiquesRepository, Request $request)
    {
        $musique = new musiques();
        $musique->setTitre($request->get('titre'));
        $musique->setOeuvre($request->get('oeuvre'));
        $musique->setDescription($request->get('desc'));
        $musique->setTimeur($request->get('timer'));
        $musique->setDifficulte($request->get('annee'));
        $musique->setAnnee($request->get('annee'));
        $musique->setLink($request->get('idvideo'));
        $musique->setTheme($request->get('theme'));

    
        $em = $this->getDoctrine()->getManager();
        $em->persist($musique);
        $em->flush();



        return $this->render('admin/ajaxadd.html.twig');
    }


}
