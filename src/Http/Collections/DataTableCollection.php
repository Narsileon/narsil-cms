<?php

declare(strict_types=1);

namespace Narsil\Cms\Http\Collections;

#region USE

use Narsil\Base\Http\Collections\DataTableCollection as BaseDataTableCollection;

#endregion

class DataTableCollection extends BaseDataTableCollection
{
    #region PUBLIC METHODS

    /**
     * @param boolean $revisionable
     *
     * @return static
     */
    public function setRevisionable(bool $revisionable): static
    {
        $this->options['revisionable'] = $revisionable;

        return $this;
    }

    /**
     * @return array<string,mixed>
     */
    public function toBladeData(): array
    {
        $payload = parent::toBladeData();

        if ($payload['meta']['revisionable'] ?? false)
        {
            $payload = $this->addRevisionStatus($payload);
        }

        return $payload;
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param array<string,mixed> $payload
     *
     * @return array<string,mixed>
     */
    private function addRevisionStatus(array $payload): array
    {
        $statusColumn = [
            'accessorKey' => '_status',
            'component' => 'narsil-cms::blocks.status.status-cell',
            'enableColumnFilter' => false,
            'enableHiding' => false,
            'enableSorting' => false,
            'header' => '',
            'id' => '_status',
            'meta' => [
                'className' => 'w-8 max-w-8 min-w-8 pl-2 transition-[min-width,width,max-width] delay-100 duration-300 hover:w-12 hover:max-w-12 hover:min-w-12',
            ],
            'visibility' => true,
        ];

        $payload['meta']['columns'] = [
            $statusColumn,
            ...$payload['meta']['columns'],
        ];

        $state = $payload['meta']['state'];
        if (is_object($state) && method_exists($state, 'toArray'))
        {
            $state = $state->toArray();
        }
        else
        {
            $state = (array) $state;
        }

        $columnOrder = collect($state['column_order'] ?? [])
            ->reject(function ($column): bool
            {
                return $column === '_status';
            })
            ->values()
            ->all();
        $state['column_order'] = ['_status', ...$columnOrder];
        $payload['meta']['state'] = $state;

        $payload['data'] = array_map(function (array $row): array
        {
            $publishedUuid = data_get($row, 'published_revision.uuid');

            $row['_status'] = [
                'draft' => (bool) data_get($row, 'draft'),
                'published' => filled($publishedUuid),
                'saved' => $publishedUuid !== data_get($row, 'uuid'),
            ];

            return $row;
        }, $payload['data']);

        return $payload;
    }

    #endregion
}
