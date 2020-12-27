<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ConsultantType;
use App\Form\ConsultantUpdateType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;

class ConsultantController extends AbstractController
{
    /**
     * @Route("/consultant", name="consultant")
     */
    public function index(): Response
    {
        return $this->render('consultant/index.html.twig', [
            'controller_name' => 'ConsultantController',
        ]);
    }


    /**
     * @Route("/inscriptionConsultant",name="addConsultant")
     */
    public function addConsultant(Request $req,UserPasswordEncoderInterface $encoder){
        $admin=new User();
        $form = $this->createForm(ConsultantType::class, $admin);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($admin, $admin->getPassword());
            $manager = $this->getDoctrine()->getManager();
            $admin->setRoles(["Consultant"]);
            $admin->setPassword($encoded);
            $manager->persist($admin);
            $manager->flush();
            return $this->redirectToRoute('accueil');
        }
        return $this->render('consultant/inscription.html.twig', [
            'form' => $form->createView()

        ]);
    }



    /**
     * @Route("/updateConsultant",name="updateConsultant")
     */
    public function UpdateConsultant(Request $req,UserPasswordEncoderInterface $encoder){
        $user=$this->getUser();
        $form = $this->createForm(ConsultantUpdateType::class, $user);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $this->getDoctrine()->getManager()->flush();

            //return $this->redirectToRoute('sondage_index');
        }


        return $this->render('consultant/update.html.twig', [
            'utilisateur' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("accueilConsultant",name="accueilConsultant")
     */
    public function homeConsultant():Response{
        return $this->redirectToRoute('forumConsultant');
    }


}
