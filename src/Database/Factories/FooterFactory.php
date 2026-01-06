<?php

namespace Narsil\Database\Factories;

#region USE

use Illuminate\Database\Eloquent\Factories\Factory;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\FooterSocialMedium;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterFactory extends Factory
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Footer $footer)
        {
            $this->createSocialMedia($footer);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function definition(): array
    {
        return [
            Footer::ADDRESS_LINE_1 => $this->faker->buildingNumber() . ' ' . $this->faker->streetName(),
            Footer::ADDRESS_LINE_2 => $this->faker->postcode() . ' ' . $this->faker->city(),
            Footer::COMPANY => $this->faker->company(),
            Footer::EMAIL => $this->faker->unique()->safeEmail(),
            Footer::SLUG => $this->faker->slug(1),
            Footer::PHONE => $this->faker->phoneNumber(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Footer $footer
     *
     * @return void
     */
    protected function createSocialMedia(Footer $footer): void
    {
        $socialMedia = [[
            FooterSocialMedium::ICON => 'linkedin',
            FooterSocialMedium::LABEL => 'LinkedIn',
            FooterSocialMedium::URL => 'https://linkedin.com'
        ], [
            FooterSocialMedium::ICON => 'instagram',
            FooterSocialMedium::LABEL => 'Instagram',
            FooterSocialMedium::URL => 'https://instagram.com'
        ]];

        foreach ($socialMedia as $key => $socialMedium)
        {
            FooterSocialMedium::create([
                FooterSocialMedium::FOOTER_ID => $footer->id,
                FooterSocialMedium::ICON => $socialMedium[FooterSocialMedium::ICON],
                FooterSocialMedium::LABEL => $socialMedium[FooterSocialMedium::LABEL],
                FooterSocialMedium::POSITION  => $key,
                FooterSocialMedium::URL => $socialMedium[FooterSocialMedium::URL],
            ]);
        }
    }

    #endregion
}
