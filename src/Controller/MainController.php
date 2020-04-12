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
        return $this->redirectToRoute('adminType', ['type' => 'titre' , 'order' => 'asc']);
    }

    /**
     * @Route("/admin/filtre/{type}/{order}", name="adminType", methods={"GET"})
     */
    public function adminType( MusiquesRepository $musiquesRepository, Request $request )
    {
        $musiques = $musiquesRepository->findBy(array(), array($request->get('type') => $request->get('order')));
        
        return $this->render('admin/index.html.twig' , [
            "musiques" => $musiques,
             "type" => $request->get('type'),
             "order" => $request->get('order')
             ]);
    }

    /**
     * @Route("/admin/add", name="add", methods={"GET"})
     */
    public function add(MusiquesRepository $musiquesRepository)
    {
        $musiques = $musiquesRepository->findAll();
        return $this->render('admin/add.html.twig', ["musiques" => $musiques]);
    }

    /**
     * @Route("/admin/delete/{id}", name="delete", methods={"GET"})
     */
    public function delete(MusiquesRepository $musiquesRepository, Request $request)
    {

        $id = $request->get('id');
        

        $musique =  $musiquesRepository->findOneBy(['id' => $id]);

        $em = $this->getDoctrine()->getManager();
        $em->remove($musique);
        $em->flush();

        	
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/ajaxadd/{titre}/{oeuvre}/{desc}/{timer}/{diff}/{annee}/{idvideo}/{theme}/{sousCat}" , name="ajaxadd", methods={"GET"})
     */
    public function ajaxadd(MusiquesRepository $musiquesRepository, Request $request)
    {
        $musique = new musiques();
        $musique->setTitre($request->get('titre'));
        $musique->setOeuvre($request->get('oeuvre'));
        $musique->setDescription($request->get('desc'));
        $musique->setTimeur($request->get('timer'));
        $musique->setDifficulte($request->get('diff'));
        $musique->setAnnee($request->get('annee'));
        $musique->setLink($request->get('idvideo'));
        $musique->setTheme($request->get('theme'));
        $musique->setSousCat($request->get('sousCat'));

    
        $em = $this->getDoctrine()->getManager();
        $em->persist($musique);
        $em->flush();



        return $this->render('admin/ajaxadd.html.twig');
    }

    /**
     * @Route("/admin/ajaxmodif/{id}/{titre}/{oeuvre}/{desc}/{timer}/{diff}/{annee}/{idvideo}/{theme}/{souscat}" , name="ajaxmodif", methods={"GET"})
     */
    public function ajaxamodif(MusiquesRepository $musiquesRepository, Request $request)
    {



        $musique = $musiquesRepository->findOneBy(['id' => $request->get('id') ]);
        $musique->setTitre($request->get('titre'));
        $musique->setOeuvre($request->get('oeuvre'));
        $musique->setDescription($request->get('desc'));
        $musique->setTimeur($request->get('timer'));
        $musique->setDifficulte($request->get('diff'));
        $musique->setAnnee($request->get('annee'));
        $musique->setLink($request->get('idvideo'));
        $musique->setTheme($request->get('theme'));
        $musique->setSousCat($request->get('souscat'));

    
        $em = $this->getDoctrine()->getManager();
        $em->persist($musique);
        $em->flush();



        return $this->render('admin/ajaxadd.html.twig');
    }

    /**
     * @Route("/admin/modif/{id}" , name="modif", methods={"GET"})
     */
    public function modif(MusiquesRepository $musiquesRepository, Request $request)
    {
        $musiques = $musiquesRepository->findAll();
        $info = $musiquesRepository->findOneBy(["id" => $request->get('id')]);

        return $this->render('admin/modif.html.twig' , ["musiques" => $musiques , "info" => $info] );
    }


}
