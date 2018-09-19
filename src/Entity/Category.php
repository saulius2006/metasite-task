<?php
// src/Entity/Task.php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Category
{
	public static function getCategories() {
		return [
			'Category 1' => 'category_1',
			'Category 2' => 'category_2',
			'Category 3' => 'category_3',
		];
	}
}