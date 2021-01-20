<?php

namespace App\Util;

abstract class SiteParserAbstract
{
    abstract function getRecipe(string $recipe_url): array;
}
