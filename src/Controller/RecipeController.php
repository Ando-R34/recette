<?php

namespace App\Controller;

use App\Entity\Engredient;
use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    #[Route('/recette', name: 'app_recipe', methods:['GET'])]
    public function index(
        RecipeRepository $repository, 
        PaginatorInterface $paginator, 
        Request $request
        ): Response
    {
        $recipes = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1)
        );

        return $this->render('pages/recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/recette/creation', 'recipe.new', methods:['GET', 'POST'] )]
    public function new(
        Request $request,
        EntityManagerInterface $manager
        ): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {
          $recipe = $form->getData();
          $manager->persist($recipe);
          $manager->flush();    

          $this->addFlash(
            'success',
            'Votre recette a été créé avec succès !'
        );

        return $this->redirectToRoute('app_recipe');
        }

        return $this->render('pages/recipe/new.html.twig',[
            'form'=> $form->createView()
        ]);
    }
}
