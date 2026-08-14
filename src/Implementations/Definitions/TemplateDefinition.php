<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Definitions;

#region USE

use Narsil\Base\Resources\AbstractModelDefinition;
use Narsil\Base\Enums\ModelHookEventEnum;
use Narsil\Cms\Contracts\Actions\Templates\ReplicateTemplate;
use Narsil\Cms\Contracts\Forms\TemplateForm;
use Narsil\Cms\Contracts\Requests\TemplateFormRequest;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Implementations\Tables\TemplateTable;
use Narsil\Cms\Implementations\Hooks\Templates\SyncTemplateTabsHook;

#endregion

final class TemplateDefinition extends AbstractModelDefinition
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function editWith(): array
    {
        return [
            Template::RELATION_TABS,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function form(): ?string
    {
        return TemplateForm::class;
    }

    public function hooks(): array
    {
        return [
            ModelHookEventEnum::AFTER_STORE->value => [
                ['hook' => SyncTemplateTabsHook::class, 'priority' => 0],
            ],
            ModelHookEventEnum::AFTER_UPDATE->value => [
                ['hook' => SyncTemplateTabsHook::class, 'priority' => 0],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function indexWith(): array
    {
        return [
            Template::RELATION_TABS,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function model(): string
    {
        return Template::class;
    }

    /**
     * {@inheritDoc}
     */
    public function replicateAction(): ?string
    {
        return ReplicateTemplate::class;
    }

    /**
     * {@inheritDoc}
     */
    public function request(): ?string
    {
        return TemplateFormRequest::class;
    }

    /**
     * {@inheritDoc}
     */
    public function route(): string
    {
        return 'templates';
    }

    public function table(): ?string
    {
        return TemplateTable::class;
    }

    #endregion
}
