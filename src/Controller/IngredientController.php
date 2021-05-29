<?php

namespace App\Controller;

use App\Entity\Ingredient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends ApiController
{
    /**
     * @Route("/ingredient", name="get_ingredient", methods={"GET"})
     * @param int $id
     *
     * @return Response
     */
    public function getIngredient(int $id): Response
    {
        $ingredient_repository = $this->getDoctrine()->getManager()->getRepository(Ingredient::class);
        $ingredient = $ingredient_repository->find($id);

        if (!$ingredient) {
            return $this->respondNotFound("Recipe not found");
        }

        return $this->response(
            [
                'ingredient' => $ingredient->jsonSerialize(),
            ]
        );
    }

    /**
     * @Route("/ingredient", name="create_ingredient", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createRecipe(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['ingredient'])) {
            return $this->respondValidationError(['Wrong ingredient']);
        }

        $ingredient_data = $data['ingredient'];

        if (isset($ingredient_data['id'])) {
            return $this->respondValidationError(['Ingredient already exist']);
        }

        $ingredient = new Ingredient();

        if (isset($ingredient_data['name'])) {
            $ingredient->setName($ingredient_data['name']);
        }

        if (isset($ingredient_data['description'])) {
            $ingredient->setDescription($ingredient_data['description']);
        }

        $this->getDoctrine()->getManager()->persist($ingredient);
        $this->getDoctrine()->getManager()->flush();

        return $this->response($ingredient->jsonSerialize());
    }
}
