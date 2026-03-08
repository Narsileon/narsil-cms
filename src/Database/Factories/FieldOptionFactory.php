<?php

namespace Narsil\Cms\Database\Factories;

#region USE

use Illuminate\Database\Eloquent\Factories\Factory;
use Narsil\Cms\Models\Collections\FieldOption;

#endregion

/**
 * @author Jonathan Rigaux
 */
class FieldOptionFactory extends Factory
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function definition(): array
    {
        return [
            FieldOption::LABEL => $this->faker->words(1),
            FieldOption::VALUE => $this->faker->randomNumber(6),
        ];
    }

    #endregion
}
