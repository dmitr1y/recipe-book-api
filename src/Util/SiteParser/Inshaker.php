<?php

namespace App\Util\SiteParser;

use App\Util\SiteParserAbstract;
use PHPHtmlParser\Dom;

class Inshaker extends SiteParserAbstract
{
    function getRecipe(string $recipe_url): array
    {
        try {
            $dom = new Dom();
            $dom->loadFromUrl($recipe_url);

            // $cocktail_block = $dom->find('#the-cocktail');
            $ingredient_tables = $dom->find('div.ingredient-tables');

            foreach ($ingredient_tables[0]->getChildren() as $ingredient_table) {
                $name = $ingredient_table->find('.js-tracking-ingredient a');
                $amount = $ingredient_table->find('.amount');
                $unit = $ingredient_table->find('.unit');
            }

            $steps = $dom->find('.steps li');

            $recipe_body = [];
            foreach ($steps as $step) {
                $recipe_body[] = $step->firstChild()->text();
            }

            echo implode("\n", $recipe_body);

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
