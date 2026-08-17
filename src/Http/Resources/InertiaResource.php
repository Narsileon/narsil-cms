<?php

declare(strict_types=1);

namespace Narsil\Cms\Http\Resources;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

#endregion

final class InertiaResource extends JsonResource
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return array<string,mixed>
     */
    public function toArray(Request $request): array
    {
        $data = is_array($this->resource) ? $this->resource : [];

        return [
            'auth' => $data['auth'] ?? null,
            'code' => $data['code'] ?? null,
            'description' => $data['description'] ?? null,
            'navigation' => $data['navigation'] ?? [
                'breadcrumb' => [],
                'home' => [],
                'sidebars' => [],
                'userMenu' => [],
            ],
            'redirect' => $data['redirect'] ?? [
                'data' => null,
                'error' => null,
                'info' => null,
                'success' => null,
                'warning' => null,
            ],
            'session' => $data['session'] ?? [
                'color' => null,
                'languages' => [],
                'locale' => app()->getLocale(),
                'radius' => null,
                'schema' => null,
                'theme' => null,
            ],
            'title' => $data['title'] ?? null,
            'translations' => $data['translations'] ?? [],
            'url' => $data['url'] ?? config('app.url'),
        ];
    }

    #endregion
}
