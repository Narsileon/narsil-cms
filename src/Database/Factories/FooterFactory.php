<?php

namespace Narsil\Database\Factories;

#region USE

use Illuminate\Database\Eloquent\Factories\Factory;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\FooterSocialLink;

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
            $this->createSocialLink($footer);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function definition(): array
    {
        return [
            Footer::COMPANY        => $this->faker->company(),
            Footer::ADDRESS_LINE_1 => $this->faker->buildingNumber() . ' ' . $this->faker->streetName(),
            Footer::ADDRESS_LINE_2 => $this->faker->postcode() . ' ' . $this->faker->city(),
            Footer::EMAIL          => $this->faker->unique()->safeEmail(),
            Footer::HANDLE         => $this->faker->slug(),
            Footer::PHONE          => $this->faker->phoneNumber(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Footer $footer
     *
     * @return void
     */
    protected function createSocialLink(Footer $footer): void
    {
        $socialLinks = [[
            FooterSocialLink::ICON => 'linkedin',
            FooterSocialLink::LABEL => 'LinkedIn',
            FooterSocialLink::URL => 'https://linkedin.com'
        ], [
            FooterSocialLink::ICON => 'instagram',
            FooterSocialLink::LABEL => 'Instagram',
            FooterSocialLink::URL => 'https://instagram.com'
        ]];

        foreach ($socialLinks as $key => $socialLink)
        {
            FooterSocialLink::create([
                FooterSocialLink::FOOTER_ID => $footer->id,
                FooterSocialLink::ICON => $socialLink[FooterSocialLink::ICON],
                FooterSocialLink::LABEL => $socialLink[FooterSocialLink::LABEL],
                FooterSocialLink::POSITION  => $key,
                FooterSocialLink::URL => $socialLink[FooterSocialLink::URL],
            ]);
        }
    }

    #endregion
}
