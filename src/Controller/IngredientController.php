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

          

            $this->addFlash(
                'success',
                'Votre ingrédient a été créé avec succès'
            );
            return $this->redirectToRoute('app_ingredient');

        }

       return $this->render('pages/ingredient/new.html.twig',[
        'form'=>$form->createView()
       ]);
    }

    #[Route('/ingredient/edition/{id}', 'ingredient.edit', methods:['GET', 'POST'] )]
    public function edit(Engredient $ingredient, Request $request, EntityManagerInterface $manager): Response
    {
               $form = $this->createForm(IngredientType::class, $ingredient);
               $form->handleRequest($request);
               if ($form->isSubmitted() && $form->isValid() ) {
                $ingredient = $form->getData();
     
                $manager->persist($ingredient);
                $manager->flush();
     
              
     
                 $this->addFlash(
                     'success',
                     'Votre ingrédient a été modifier avec succès'
                 );
                 return $this->redirectToRoute('app_ingredient');
     
             }

        return $this->render('pages/ingredient/edit.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('ingredient/suppression/{id}', 'ingredient.delete', methods:['GET'])]
    public function delete(EntityManagerInterface $manager, Engredient $ingredient) : Response
    {
        if(!$ingredient){
            $this->addFlash(
                'warning',
                'L\'ingredient n\'est pas là'
            );
        }

        $manager->remove($ingredient);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre ingredient a été supprimé avec succès'
        );

        return $this->redirectToRoute('app_ingredient');
    }

}
