<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Entity\RecipeIngredient;
use App\Entity\RecipeTool;
use App\Entity\Tool;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends ApiController
{
    /**
     * @Route("/recipe", name="get_recipe", methods={"GET"})
     * @param int $id
     *
     * @return Response
     */
    public function getRecipe(int $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $recipe_repository = $em->getRepository(Recipe::class);

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
     * @Route("/recipe", name="create_recipe", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createRecipe(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['recipe'])) {
            return $this->respondValidationError(['Wrong recipe']);
        }

        $recipe_data = $data['recipe'];

        if (isset($recipe_data['id'])) {
            return $this->respondValidationError(['Recipe already exist']);
        }

        /** @var User $user */
        $user = $this->getUser();

        $recipe = new Recipe();

        if (!isset($recipe_data['title'])) {
            return $this->respondValidationError(['message' => 'Wrong title']);
        }

        $recipe->setTitle($recipe_data['title']);
        $recipe->setDescription($recipe_data['description']);
        $recipe->setBody($recipe_data['body']);

        $recipe->setCreator($user);

        $tools = $this->createTools($recipe_data, $recipe);
        $recipe->setTools($tools);
        $recipe->setIngredients(
            $this->createIngredients($recipe_data)
        );

        $em = $this->getDoctrine()->getManager();
        $em->persist($recipe);
        $em->flush();

        return $this->response(
            [
                'success' => true,
                'recipe' => $recipe,
            ]
        );
    }

    private function createTools(array $data, Recipe $recipe): void
    {
        if (!isset($data['tools'])) {
            $recipe->setTools([]);

            return;
        }

        $em = $this->getDoctrine()->getManager();
        $tool_repository = $em->getRepository(Tool::class);
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

            if (!$tool) {
                $this->respondWithErrors("Tool with id {$recipe_tool_data['id']} not found");
            }

            $recipe_tool = (new RecipeTool())
                ->setTool($tool)
                ->setCount($recipe_tool_data['count'])
                ->setCreatorId($user->getId());

            $em->persist($recipe_tool);

            $created_tools[] = $recipe_tool;
        }

        $recipe->setTools($created_tools);
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
        $ingredient_repository = $em->getRepository(Ingredient::class);
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
