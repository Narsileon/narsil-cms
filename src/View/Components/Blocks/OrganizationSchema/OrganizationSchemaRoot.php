<?php

declare(strict_types=1);

namespace Narsil\Cms\View\Components\Blocks\OrganizationSchema;

#region USE

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

#endregion

final class OrganizationSchemaRoot extends Component
{
    #region CONSTRUCTOR

    /**
     * @param array<string,mixed> $footer
     * @param array<string,string|null> $session
     *
     * @return void
     */
    public function __construct(array $footer, array $session)
    {
        $this->schema = $this->createSchema($footer, $session);
    }

    #endregion

    #region PROPERTIES

    /**
     * @var array<string,mixed>
     */
    public readonly array $schema;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function render(): View
    {
        return view('narsil-cms::components.blocks.organization-schema.organization-schema-root');
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param array<string,mixed> $footer
     * @param array<string,string|null> $session
     *
     * @return array<string,mixed>
     */
    private function createSchema(array $footer, array $session): array
    {
        $schema = [];

        if ($footer['organization_schema'] ?? false)
        {
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => $footer['organization'],
                'url' => $session['url'],
                'logo' => $session['url'] . '/favicon.svg',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $footer['street'],
                    'postalCode' => $footer['postal_code'],
                    'addressLocality' => $footer['city'],
                    'addressCountry' => $footer['country'],
                ],
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'telephone' => $footer['phone'],
                    'email' => $footer['email'],
                ],
                'sameAs' => Collection::make($footer['social_media'])->pluck('url')->all(),
            ];
        }

        return $schema;
    }

    #endregion
}
