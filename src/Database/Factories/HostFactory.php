<?php

namespace Narsil\Cms\Database\Factories;

#region USE

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Config;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostFactory extends Factory
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Host $host)
        {
            $this->createHostLocale($host);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function definition(): array
    {
        $baseUrl = parse_url(Config::get('app.url'), PHP_URL_HOST);

        $hostname = $this->faker->domainWord() . '.' .  $baseUrl;

        return [
            Host::HOSTNAME => $hostname,
            Host::LABEL => $hostname,
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Host $host
     *
     * @return void
     */
    protected function createHostLocale(Host $host): void
    {
        $hostLocale = HostLocale::create([
            HostLocale::HOST_ID  => $host->{Host::ID},
            HostLocale::COUNTRY  => 'default',
            HostLocale::PATTERN  => "https://{host}/{language}",
            HostLocale::POSITION => 0,
        ]);

        $this->createHostLocaleLanguages($hostLocale);
    }

    /**
     * @param HostLocale $hostLocale
     *
     * @return void
     */
    protected function createHostLocaleLanguages(HostLocale $hostLocale): void
    {
        $languages = Config::get('narsil.locales', []);

        foreach ($languages as $position => $language)
        {
            HostLocaleLanguage::create([
                HostLocaleLanguage::LOCALE_UUID => $hostLocale->{HostLocale::UUID},
                HostLocaleLanguage::LANGUAGE    => $language,
                HostLocaleLanguage::POSITION    => $position,
            ]);
        }
    }

    #endregion
}
