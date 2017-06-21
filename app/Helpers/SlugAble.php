<?php

namespace App\Helpers;

interface SlugAble
{
	/**
	 * Generate and set slug to model.
	 *
	 * @return 	string 	$slug
	 */
	public function makeSlug();
}
