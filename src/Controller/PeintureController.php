<?php

namespace App\Controller;

use App\Entity\Peinture;
use App\Form\PeintureType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PeintureController extends AbstractController
{
    #[Route('/peinture', name: 'app_peinture')]
    public function index(ManagerRegistry $manager,Request $request): Response
    {
        $image = new Peinture();
        $imageForm = $this->createForm(PeintureType::class,$image);
        $imageForm->handleRequest($request);

        if($imageForm->isSubmitted() && $imageForm->isValid()){
            $image->setFile('images/articles');
            $manager->getManager()->persist($image);
            $manager->getManager()->flush();
        }        
        return $this->render('peinture/index.html.twig', [
            'dataForm' => $imageForm->createView(),
        ]);
    }
}
