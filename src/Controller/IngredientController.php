<?php

namespace App\Controller;

use App\Entity\Engredient;
use App\Form\IngredientType;
use App\Repository\EngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    #[Route('/ingredient', name: 'app_ingredient')]
    public function index(EngredientRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {

        $ingredient = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1)
        );

        return $this->render('pages/ingredient/index.html.twig', [
            'ingredients'=> $ingredient
         ]);
    }


    #[Route('/ingredient/nouveau', 'ingredient.new', methods:['GET','POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
        ) : Response
    {
        $ingredient = new Engredient();

        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
           $ingredient = $form->getData();

           $manager->persist($ingredient);
           $manager->flush();
        }



       return $this->render('pages/ingredient/new.html.twig',[
        'form'=>$form->createView()
       ]);
    }
}
