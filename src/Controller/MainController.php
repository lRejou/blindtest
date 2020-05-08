<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MusiquesRepository;
use App\Entity\Musiques;
use App\Repository\ProposeRepository;
use App\Entity\Propose;
use App\Repository\ReportRepository;
use App\Entity\Report;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(MusiquesRepository $musiquesRepository )
    {
        return $this->redirect('/accueil');
        return $this->render('main/index.html.twig');
    }

    /**
     * @Route("/accueil", name="accueil")
     */
    public function accueil(MusiquesRepository $musiquesRepository )
    {
        return $this->render('main/accueil.html.twig');
    }

    /**
     * @Route("/proposemusique", name="proposeMusique" , methods={"GET" , "POST"})
     */
    public function proposeMusique(MusiquesRepository $musiquesRepository , Request $request , ProposeRepository $proposeRepository)
    {
        if( !empty( $request->get('titre')) ){



            
            $propose = new propose();
            $propose->setTitre($request->get('titre'));
            $propose->setOeuvre($request->get('oeuvre'));
            $propose->setDescription($request->get('desc'));
            $propose->setTimeur($request->get('timer'));
            $propose->setDifficulte($request->get('diff'));
            $propose->setAnnee($request->get('annee'));
            $propose->setLink($request->get('urlvideo'));
            $propose->setSousCat($request->get('SelectCatMusique'));
            $propose->setTheme($request->get('theme'));
            $propose->setReport(0);
            $propose->setDateadd(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($propose);
            $em->flush();
            
            return $this->redirect('/proposemusique');
        }


        return $this->render('main/proposemusique.html.twig');
    }

    /**
     * @Route("/listsong", name="listsong", methods={"GET" , "POST"})
     */
    public function listsong(MusiquesRepository $musiquesRepository, Request $request  )
    {

        $listmusique = $musiquesRepository->findAll();


        return $this->json($listmusique);
    }

    /**
     * @Route("/listsound", name="listsound", methods={"GET" , "POST"})
     */
    public function listsound( MusiquesRepository $musiquesRepository, Request $request )
    {
        $soustheme = explode(",", $request->get('soustheme'));
        //var_dump($soustheme);

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
        $listmusique = $musiquesRepository->findId($tabDiff, $theme, $soustheme);

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
     * @Route("/report/{id}", name="report", methods={"GET"})
     */
    public function report( MusiquesRepository $musiquesRepository, Request $request )
    {
        $id = $request->get('id');

        $musique = $musiquesRepository->findOneBy(["id" => $id]);

        $musique->setReport(1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($musique);
        $em->flush();

        return $this->json();
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

        $report = $musiquesRepository->findBy(["report" => 1]);
        
        return $this->render('admin/index.html.twig' , [
            "musiques" => $musiques,
             "type" => $request->get('type'),
             "order" => $request->get('order'),
             "report" => $report
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
        $musique->setReport(0);

    
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

    /**
     * @Route("/admin/report" , name="adminreport", methods={"GET"})
     */
    public function adminreport(MusiquesRepository $musiquesRepository, Request $request , ReportRepository $reportRepository)
    {

        $report = $musiquesRepository->findBy(["report" => 1]);

        return $this->render('admin/report.html.twig' , ["reports" => $report] );
    }

    /**
     * @Route("/admin/propose" , name="admin_propose", methods={"GET" , "POST"})
     */
    public function adminPropose(ProposeRepository $proposeRepository, Request $request)
    {
        $propose = $proposeRepository->findAll();

        return $this->render('admin/propose.html.twig' , ["proposes" => $propose] );
    }

    /**
     * @Route("/admin/validepropose/{id}" , name="admin_validepropose", methods={"GET" , "POST"})
     */
    public function adminProposeValide(ProposeRepository $proposeRepository, MusiquesRepository $musiquesRepository, Request $request)
    {
        $propose = $proposeRepository->findOneBy(["id" => $request->get('id')]);


            $newMusique = new musiques();
            $newMusique->setTitre($propose->getTitre());
            $newMusique->setOeuvre($propose->getOeuvre());
            $newMusique->setDescription($propose->getDescription());
            $newMusique->setTimeur($propose->getTimeur());
            $newMusique->setDifficulte($propose->getDifficulte());
            $newMusique->setAnnee($propose->getAnnee());
            $newMusique->setLink($propose->getLink());
            $newMusique->setSousCat($propose->getSousCat());
            $newMusique->setTheme($propose->getTheme());
            $newMusique->setReport(0);
            $newMusique->setDateadd($propose->getDateadd());

            $em = $this->getDoctrine()->getManager();
            $em->persist($newMusique);
            $em->flush();

            $em->remove($propose);
            $em->flush();

        return $this->redirect('/admin/propose');
    }

        /**
     * @Route("/admin/deletepropose/{id}" , name="admin_Deletepropose", methods={"GET" , "POST"})
     */
    public function adminDeleteValide(ProposeRepository $proposeRepository, MusiquesRepository $musiquesRepository, Request $request)
    {
        $propose = $proposeRepository->findOneBy(["id" => $request->get('id')]);

            
        $em = $this->getDoctrine()->getManager();
        $em->remove($propose);
        $em->flush();

        return $this->redirect('/admin/propose');
    }




}
