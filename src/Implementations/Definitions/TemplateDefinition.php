<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Definitions;

#region USE

use Narsil\Base\Resources\AbstractModelDefinition;
use Narsil\Cms\Contracts\Actions\Templates\ReplicateTemplate;
use Narsil\Cms\Contracts\Forms\TemplateForm;
use Narsil\Cms\Contracts\Requests\TemplateFormRequest;
use Narsil\Cms\Models\Collections\Template;

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

    #endregion
}
