<?php

declare(strict_types=1);

namespace Narsil\Cms\Database\Factories;

#region USE

use Illuminate\Database\Eloquent\Factories\Factory;
use Narsil\Cms\Models\Globals\Header;

#endregion

class HeaderFactory extends Factory
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function definition(): array
    {
        return [
            Header::SLUG => $this->faker->slug(1),
        ];
    }

    #endregion
}
