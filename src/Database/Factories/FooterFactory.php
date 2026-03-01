<?php

namespace Narsil\Cms\Database\Factories;

#region USE

use Illuminate\Database\Eloquent\Factories\Factory;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\FooterSocialMedium;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterFactory extends Factory
{
    #region CONSTANTS

    /**
     * @var array
     */
    protected const SOCIAL_MEDIA = [
        [
            FooterSocialMedium::ICON => 'facebook',
            FooterSocialMedium::LABEL => 'Facebook',
            FooterSocialMedium::URL => 'https://www.facebook.com'
        ],
        [
            FooterSocialMedium::ICON => 'instagram',
            FooterSocialMedium::LABEL => 'Instagram',
            FooterSocialMedium::URL => 'https://instagram.com'
        ],
        [
            FooterSocialMedium::ICON => 'linkedin',
            FooterSocialMedium::LABEL => 'LinkedIn',
            FooterSocialMedium::URL => 'https://linkedin.com'
        ],
        [
            FooterSocialMedium::ICON => 'tiktok',
            FooterSocialMedium::LABEL => 'TikTok',
            FooterSocialMedium::URL => 'https://www.tiktok.com'
        ],
        [
            FooterSocialMedium::ICON => 'youtube',
            FooterSocialMedium::LABEL => 'Youtube',
            FooterSocialMedium::URL => 'https://www.youtube.com'
        ],
    ];

    #endregion

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
            Footer::CITY => $this->faker->city(),
            Footer::COUNTRY => $this->faker->countryCode(),
            Footer::EMAIL => $this->faker->unique()->safeEmail(),
            Footer::ORGANIZATION => $this->faker->company(),
            Footer::SLUG => $this->faker->slug(1),
            Footer::PHONE => $this->faker->phoneNumber(),
            Footer::POSTAL_CODE => $this->faker->postcode(),
            Footer::STREET => $this->faker->buildingNumber() . ' ' . $this->faker->streetName(),
            Footer::COPYRIGHT => [
                'en' => 'All rights reserved.',
                'de' => 'Alle Rechte vorbehalten.',
                'fr' => 'Tous droits réservés.',
            ],
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
        $socialMedia = collect(self::SOCIAL_MEDIA)
            ->shuffle()
            ->take(3)
            ->values();

        foreach ($socialMedia as $position => $socialMedium)
        {
            FooterSocialMedium::create([
                FooterSocialMedium::FOOTER_ID => $footer->{Footer::ID},
                FooterSocialMedium::ICON => $socialMedium[FooterSocialMedium::ICON],
                FooterSocialMedium::LABEL => $socialMedium[FooterSocialMedium::LABEL],
                FooterSocialMedium::POSITION  => $position,
                FooterSocialMedium::URL => $socialMedium[FooterSocialMedium::URL],
            ]);
        }
    }

    #endregion
}
