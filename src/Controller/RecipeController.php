<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Entity\RecipeIngredient;
use App\Entity\RecipeTool;
use App\Entity\Tool;
use App\Entity\User;
use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;
use App\Repository\ToolRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends ApiController
{
    /**
     * @Route("/recipe", name="recipe", methods={"GET"})
     * @param int $id
     *
     * @return Response
     */
    public function index(int $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $recipe_repository = $em->getRepository(RecipeRepository::class);

        /** @var Recipe $recipe */
        $recipe = $recipe_repository->findBy(
            [
                'id' => $id,
            ]
        );

        return $this->response(
            [
                'success' => true,
                'recipe' => $recipe,
            ]
        );
    }

    /**
     * @Route("/recipe/create", name="recipe", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        /** @var User $user */
        $user = $this->getUser();

        $recipe = new Recipe();

        if (!isset($data['title'])) {
            return $this->respondValidationError(['message' => 'Wrong title']);
        }

        $recipe->setTitle($data['title']);
        $recipe->setDescription($data['description']);
        $recipe->setBody($data['body']);

        $recipe->setCreator($user);
        $recipe->setTools(
            $this->createTools($data)
        );
        $recipe->setIngredients(
            $this->createIngredients($data)
        );

        $this->getDoctrine()->getManager()->persist($recipe);

        return $this->response(
            [
                'success' => true,
                'recipe' => $recipe,
            ]
        );
    }

    /**
     * @param array $data
     *
     * @return RecipeTool[]
     */
    private function createTools(array $data): array
    {
        if (!isset($data['tools'])) {
            return [];
        }

        $em = $this->getDoctrine()->getManager();
        $tool_repository = $em->getRepository(ToolRepository::class);
        /** @var User $user */
        $user = $this->getUser();

        $created_tools = [];

        foreach ($data['tools'] as $recipe_tool_data) {
            /** @var Tool $tool */
            $tool = $tool_repository->findOneBy(
                [
                    'id' => $recipe_tool_data['id'],
                ]
            );

            $recipe_tool = (new RecipeTool())
                ->setTool($tool)
                ->setCount($recipe_tool_data['count'])
                ->setCreatorId($user->getId());

            $em->persist($recipe_tool);

            $created_tools[] = $recipe_tool;
        }

        return $created_tools;
    }

    /**
     * @param array $data
     *
     * @return RecipeIngredient[]
     */
    private function createIngredients(array $data): array
    {
        if (!isset($data['ingredients'])) {
            return [];
        }

        $em = $this->getDoctrine()->getManager();
        $ingredient_repository = $em->getRepository(IngredientRepository::class);
        /** @var User $user */
        $user = $this->getUser();

        $created_ingredients = [];

        foreach ($data['ingredients'] as $recipe_ingredient_data) {
            /** @var Ingredient $ingredient */
            $ingredient = $ingredient_repository->findOneBy(
                [
                    'id' => $recipe_ingredient_data['id'],
                ]
            );

            $recipe_ingredient = (new RecipeIngredient())
                ->setIngredient($ingredient)
                ->setCount($recipe_ingredient_data['count'])
                ->setCreatorId($user->getId());

            $em->persist($recipe_ingredient);

            $created_ingredients[] = $recipe_ingredient;
        }

        return $created_ingredients;
    }
}
