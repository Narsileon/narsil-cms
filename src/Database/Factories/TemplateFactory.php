<?php

namespace Narsil\Cms\Database\Factories;

#region USE

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Narsil\Cms\Models\Collections\Template;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateFactory extends Factory
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function definition(): array
    {
        $slug = $this->faker->slug(1);

        return [
            Template::TABLE_NAME => Str::snake($slug),
            Template::SINGULAR => Str::headline($slug),
            Template::PLURAL => Str::headline($slug),
        ];
    }

    #endregion
}
