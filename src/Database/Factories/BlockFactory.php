<?php

namespace Narsil\Cms\Database\Factories;

#region USE

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Narsil\Cms\Models\Collections\Block;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockFactory extends Factory
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function definition(): array
    {
        $slug = $this->faker->slug(1);

        return [
            Block::HANDLE => Str::snake($slug),
            Block::LABEL => Str::headline($slug),
        ];
    }

    #endregion
}
