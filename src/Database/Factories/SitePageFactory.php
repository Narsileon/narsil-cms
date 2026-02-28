<?php

namespace Narsil\Cms\Database\Factories;

#region USE

use Illuminate\Database\Eloquent\Factories\Factory;
use Narsil\Cms\Models\Sites\SitePage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageFactory extends Factory
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function definition(): array
    {
        return [
            SitePage::SLUG => $this->faker->slug(1),
            SitePage::TITLE => $this->faker->words(1),
        ];
    }

    #endregion
}
