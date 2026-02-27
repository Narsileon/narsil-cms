<?php

namespace Narsil\Cms\Database\Factories;

#region USE

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Narsil\Cms\Models\Collections\Element;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ElementFactory extends Factory
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function definition(): array
    {
        $slug = $this->faker->slug(1);

        return [
            Element::HANDLE => Str::snake($slug),
            Element::LABEL => Str::headline($slug),
        ];
    }

    #endregion
}
