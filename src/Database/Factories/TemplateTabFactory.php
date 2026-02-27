<?php

namespace Narsil\Cms\Database\Factories;

#region USE

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Narsil\Cms\Models\Collections\TemplateTab;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateTabFactory extends Factory
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function definition(): array
    {
        $slug = $this->faker->slug(1);

        return [
            TemplateTab::HANDLE => Str::snake($slug),
            TemplateTab::LABEL => Str::headline($slug),
        ];
    }

    #endregion
}
