<?php

namespace App\Controller;

use App\Entity\Sondage;
use App\Entity\Option;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\SondageRepondu;
use App\Entity\User;
use App\Form\SondageType;
use App\Repository\SondageRepository;
use App\Repository\ReponseRepository;
use App\Repository\QuestionRepository;
use App\Repository\SujetRepository;
use App\Repository\EnqueteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/Reponse")
 */
class ReponseController extends AbstractController
{
    /**
     * @Route("/Repondre/{idSondage} ",name="repondre",methods="GET")
     */
    public function Repondre( $idSondage){
        $repo1=$this->getDoctrine()->getRepository(Question::class);
        $Questions=$repo1->findByNbrSondage($idSondage);
        $Options=[];
        
        
        foreach($Questions as $question)
        {    
            $repo2=$this->getDoctrine()->getRepository(Option::class);
            $Options=array_merge($Options,$repo2->findByIdQuestion($question->getId()));
        }
       
        

        return $this->render('sondage/repondre.html.twig',[
            'Questions'=>$Questions,
            'Options'=>$Options,
            'idSondage'=>$idSondage
        ]);
    }


/**
     * @Route("/Repondre/{id}/{idSondage} ",name="RecupererReponse",methods="POST")
     */
    public function RecupererReponse($id, $idSondage){
        $repo1=$this->getDoctrine()->getRepository(Question::class);        
        $Questions=$repo1->findByNbrSondage($idSondage);        
        $repo2=$this->getDoctrine()->getRepository(User::class);    
        $repo3=$this->getDoctrine()->getRepository(Sondage::class);    
        $sondageRepondu= new SondageRepondu();
        //sondageRepondu
        $sondageRepondu->setSonde($repo2->find($id));
        $sondageRepondu->setSondage($repo3->find($idSondage));

        foreach($Questions as $question)
        {  
            $reponse=new Reponse();
            $entityManager = $this->getDoctrine()->getManager();
            //Reponse
            $reponse->setQuestion($question);
            $reponse->setUser($repo2->find($id));
            $reponse->setText($_POST[$question->getId()]);
            

            $entityManager->persist($reponse);
            $entityManager->persist($sondageRepondu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sondageRepondu',['idSonde'=>$id]);
       /* return $this->render('accueil.html.twig',
                            [ 'id'=>$id,                                        
                            'post'=>$tab,                                        
                            'idSondage'=>$idSondage]);*/
        
        
    }

    /**
     * @Route("/AffichageRepondre/{id}/{idSondage} ",name="AffichageReponse",methods="GET")
     */
    public function AffichageReponse($id, $idSondage){
        $repo1=$this->getDoctrine()->getRepository(Question::class);        
        $Questions=$repo1->findByNbrSondage($idSondage);        
        $repo2=$this->getDoctrine()->getRepository(Reponse::class);    
        $Reponses=[];
        $tab=[];
        $tab2=[];
        $tabK=[];
        $tabV=[];
        $tabQ=[];
        $tabQ1=[];
        $tabQ2=[];
        $tabQ12=[];
        $tabQ22=[];
   
        foreach($Questions as $question)
        {  
            $Reponses=array_merge($Reponses,$repo2->findByIdQuestion($question->getId()));   
        }
        foreach($Reponses as $reponse)
        {     
              array_push($tab,$reponse->getText());
              if (! in_array($reponse->getQuestion()->getTexte(),$tabQ))
                  { array_push($tabQ,array($reponse->getText(),$reponse->getQuestion()->getTexte()));}      }

        $tab2=array_count_values($tab); 
        
        foreach ($tab2 as $k => $v)  {
                array_push($tabK,$k);
                array_push($tabV,$v);
        }
        foreach ($tabQ as $q1 => $q2)  {
            array_push($tabQ1,$q1);
            array_push($tabQ2,$q2);
        }
        foreach ($tabQ2 as $r => $qr ) {
            array_push($tabQ12,$r);
            if (! in_array($qr,$tabQ22))
           { array_push($tabQ22,$qr);}
        }


        return $this->render('reponse/AffichageReponse.html.twig',
                            ['id'=>$id,                                        
                            'tabK'=>$tabK,
                            'tabV'=>$tabV,
                            'tabQ2'=>$tabQ22,
                            'Questions'=>$Questions,                                     
                            'idSondage'=>$idSondage]);
        
        
    }

    


}
