<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sondage;
use App\Entity\Question;
use Symfony\Component\HttpFoundation\JsonResponse;

class StatisticController extends AbstractController
{
    /**
     * @Route("/statistic", name="statistic")
     */
    public function index(): Response
    {
        return $this->render('statistic/index.html.twig', [
            'controller_name' => 'StatisticController',
        ]);
    }

    /**
    *@Route("/statisticReponse/{id}/display",name="calcule")
    */
    public function calcule(Sondage $sondage){
        //$user=$this->getUser();
        //$sondages=$user-> getSondages();
        $questions=$sondage->getQuestions();
        $i=0;
        $res=array();
        $l=count($questions);
        while($i<$l){
            $choix=$questions[$i]->getOptions();
            $reponses=$questions[$i]->getReponses();
            $stat=array();
            if($choix!= null && $reponses!=null){
                $j=0;
                while($j<count($choix)){
                    $k=0;
                    $tab=$reponses;
                    $ch=$choix[$j];
                    $cpt=0;
                    while ($k<count($tab)) {
                        if($tab[$k]->getText()==$ch->getContenue()){
                            $cpt++;
                        }
                        $k++;
                    }
                    $t=array("$ch"=>$cpt);
                    array_push ($res,$t);
                    $j++;
                }
            }
            $i++;
        }
        // TODO 
        return new JsonResponse(['stat'=>$res,'id'=>$sondage->getId()]);
        
    }


    /**
     * @Route("/stats/{question}",name="sondage_stat")
     */
    public function questionStat(Question $question){
         $options=$question->getOptions();
         $reponses=$question->getReponses();
         $valeur=[];
         $option=[];
         foreach ($options as $key) {
             $k=0;
             foreach ($reponses as $j) {
                 # code...
                 if($key->getContenue()==$j->getText()){
                     $k++;
                 }
             }
             array_push($option,$key->getContenue());
             array_push($valeur,$k);
         }       
        
        return $this->render("statistic/stat.html.twig",[
            'options'=> \json_encode($option),
            'valeurs'=>json_encode($valeur),
            'question'=>$question
        ]);
    }
}
