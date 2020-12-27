<?php

namespace App\Controller;

use App\Entity\Sondage;
use App\Entity\Cadeau;
use App\Entity\SondageRepondu;
use App\Entity\Question;
use App\Entity\Remise;
use App\Entity\Paiement;
use App\Entity\PaiementConsulting;
use App\Form\PaiementConsultingType;
use App\Form\PaiementType;
use App\Entity\NouveauType;
use App\Form\SondageType;
use App\Repository\SondageRepository;
use App\Repository\SujetRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sondage")
 */
class SondageController extends AbstractController
{
    /**
     * @Route("/listesondagemiseenligne",name="sondageMiseEnLigne")
     */
    public function listSondagePaye(){
        $sondages=$this->getUser()->getSondages();
        $i=0;
        $res=[];
        $l=count($sondages);
        while($i<$l){
            if($sondages[$i]->getMisEnLigne()==1){
                array_push ($res,$sondages[$i]);
            }
            $i++;
        }
        foreach($sondages as $son)
        {    
            $em1=$this->getDoctrine()->getManager();
            $NbrQuestion =count($em1->getRepository(Question::class)->findByNbrSondage($son->getId()));
            $son->setNbQuestion($NbrQuestion);
            $em1->flush();
        }
        
        return $this->render("sondage/listeSondageMiseEnLigne.html.twig",['sondages'=>$res,'idEnqueteur'=>$this->getUser()->getId()]);
    }

    /**
     * @Route("/sondageRepondu/{idSonde}", name="sondageRepondu", methods={"GET"})
     */
    public function sondageRepondu( $idSonde): Response
    {
        $repo=$this->getDoctrine()->getRepository(SondageRepondu::class);
        $sondages1=$repo->findAll();
        $sondages=[];
        
        foreach($sondages1 as $son)
        {    if ($son->getSonde()->getId()==$idSonde)
                { 
                    array_push($sondages,$son);
                }
        }

        return $this->render('sondage\sondagerepondu.html.twig',
                                        ['sondages'=>$sondages,
                                        'id'=>$idSonde,]);
    }
/**
     * @Route("/paiementSondage/{idSondage}",name="paiementSondage")
     */
    public function payerSondage(Request $req, $idSondage,SondageRepository $sondageRepository){
        $paiement = new Paiement();
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $paiement->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $sondage = $sondageRepository->find($idSondage);
            $sondage->setMisEnLigne(true);
            $entityManager->persist($sondage);
            $entityManager->flush();

            //$entityManager->flush();
            //return $this->redirectToRoute("updateS",['id'=>$sondage->getId()]);
            return $this->redirectToRoute("sondageMiseEnLigne");
        }
        return $this->render("paiement\paiementSondage.html.twig",['idSondage'=>$idSondage,'form'=>$form->createView()]);
    }
    /**
     * @Route("/paiementConsulting/{idSondage}",name="paiementConsulting")
     */
    public function payerConsulting(Request $req, $idSondage,SondageRepository $sondageRepository){
        $paiement = new PaiementConsulting();
        $form = $this->createForm(PaiementConsultingType::class, $paiement);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $paiement->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $sondage = $sondageRepository->find($idSondage);
            $entityManager->persist($paiement);
            $entityManager->flush();

            //$entityManager->flush();
            //return $this->redirectToRoute("updateS",['id'=>$sondage->getId()]);
            return $this->redirectToRoute("forum",['idSondage'=>$idSondage]);
        }
        return $this->render("paiement\paiementConsulting.html.twig",['idSondage'=>$idSondage,'form'=>$form->createView()]);
    }
      


   
 /**
     * @Route("/sondages/{idSonde}",name="listesondage",methods="GET")
     */
    public function getSondages($idSonde){
        $repo=$this->getDoctrine()->getRepository(Sondage::class);
        $sondages1=$repo->findAll();
        $sondages=[];
        $repo1=$this->getDoctrine()->getRepository(SondageRepondu::class);
        $sondages2=$repo1->findAll();
        $tabSonde=[];

        foreach($sondages2 as $son2)
        { 
            array_push($tabSonde,array($son2->getSonde()->getId(),$son2->getSondage()->getId()));
            
        }    
        foreach($sondages1 as $son1)
        {    
            if ($son1->getMisEnLigne()==true)
                {   $em1=$this->getDoctrine()->getManager();
                    $NbrSondage =count($em1->getRepository(Question::class)->findByNbrSondage($son1->getId()));
                    $son1->setNbQuestion($NbrSondage );
                    $em1->flush();
                    foreach($tabSonde as $t)
                        { 
                            
                            if( ( ! in_array($son1,$sondages))&&(! in_array(array($idSonde,$son1->getId()),$tabSonde)))
                                {
                                                        array_push($sondages,$son1);

                                } 
                        }
                }
        }
        return $this->render('sondage/liste_sondage.html.twig',[
            'sondages'=>$sondages,
            'id'=>$idSonde,
     
        ]);
    }
/**
 * @Route("/sondages/{sondage}/Questions",name="sondageQuestions")
 */
public function sondageQuestions(Sondage $sondage){
    $questions=$sondage->getQuestions();
    return $this->render("sondage/question.html.twig",['questions'=>$questions,'sondage'=>$sondage]);
}

   /**
     * @Route("/{idEnqueteur}", name="sondage_index", methods={"GET"})
     */
    public function index($idEnqueteur,SondageRepository $sondageRepository): Response
    {
        $sondages=$sondageRepository->findByIdEnqueteur($idEnqueteur);
        $sondagesNOnVisible=[];
        $l=count($sondages);
        $i=0;
        while($i<$l){
            if($sondages[$i]->getMisEnLigne()==0){
                array_push ($sondagesNOnVisible,$sondages[$i]);
            }
            $i++;
        }

        foreach($sondagesNOnVisible as $son)
        {    
            $em1=$this->getDoctrine()->getManager();
            $NbrQuestion =count($em1->getRepository(Question::class)->findByNbrSondage($son->getId()));
            $son->setNbQuestion($NbrQuestion);
            $em1->flush();
        }
        
        return $this->render('sondage/index.html.twig', [
            'sondages' => $sondagesNOnVisible,
            'idEnqueteur'=>$idEnqueteur
            ]);
    }
    
   

    /**
     * @Route("/new/{idEnqueteur}/{idSujet}", name="sondage_new", methods={"GET","POST"})
     */
    public function new($idEnqueteur, $idSujet,Request $request,SujetRepository $sujetRepository,UserRepository $enqueteurRepository): Response
    {
        $sondage = new Sondage();
        $form = $this->createForm(SondageType::class, $sondage);
        $form->handleRequest($request);
        $sujet=$sujetRepository->find($idSujet);
        $enqueteur=$enqueteurRepository->find($idEnqueteur);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $sondage->setSujet($sujet);
            $sondage->setEnqueteur($enqueteur);
            $entityManager->persist($sondage);
            $entityManager->flush();

            return $this->redirectToRoute('consulting',['idSondage'=>$sondage->getId() , 
                                                        'idEnqueteur'=>$idEnqueteur ]);
        }

        return $this->render('sondage/new.html.twig', [
            'sondage' => $sondage,
            'idEnqueteur'=>$idEnqueteur,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/{idEnqueteur}", name="sondage_show", methods={"GET"})
     */
    public function show($idEnqueteur,Sondage $sondage): Response
    {
        return $this->render('sondage/show.html.twig', [
            'sondage' => $sondage,
            'idEnqueteur'=>$idEnqueteur
        ]);
    }

    /**
     * @Route("/{id}/edit/{idEnqueteur}", name="sondage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sondage $sondage, $idEnqueteur): Response
    {
        $form = $this->createForm(SondageType::class, $sondage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sondage_index',
                                            ['idEnqueteur'=> $idEnqueteur]);
        }

        return $this->render('sondage/edit.html.twig', [
            'sondage' => $sondage,
            'form' => $form->createView(),
            'idEnqueteur'=>$idEnqueteur
        ]);
    }

    /**
     * @Route("/{id}/{idEnqueteur}", name="sondage_delete", methods={"DELETE"})
     */
    public function delete($idEnqueteur,Request $request, Sondage $sondage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sondage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sondage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sondage_index',
                                      ['idEnqueteur'=> $idEnqueteur]);
    }
    /**
     * @Route("/sondagee/{id}",name="sondagee")
     * @param $id
     */
    public function getQuestion($id,SondageRepository $sondageRepository){

            $sondage=$sondageRepository->find($id);
            dd($sondage);

    }


    /**
     * @Route("consulting/{idEnqueteur}/{idSondage}", name="consulting", methods={"GET"})
     */
    public function consulting($idEnqueteur, $idSondage): Response
    {
        return $this->render('consulting/index.html.twig',['idSondage'=>$idSondage,
                                                            'idEnqueteur'=> $idEnqueteur]);
    }


    
}
