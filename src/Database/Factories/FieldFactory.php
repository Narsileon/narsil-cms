<?php

namespace Narsil\Cms\Database\Factories;

#region USE

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldFactory extends Factory
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function definition(): array
    {
        $slug = $this->faker->slug(1);

        return [
            Field::HANDLE => Str::snake($slug),
            Field::LABEL => Str::headline($slug),
            Field::TYPE => 'text',
        ];
    }

    #endregion
}
