<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Definitions;

#region USE

use Narsil\Base\Enums\ModelOperationEnum as Operation;
use Narsil\Base\Resources\AbstractModelDefinition;
use Narsil\Cms\Contracts\Actions\Footers\ReplicateFooter;
use Narsil\Cms\Contracts\Forms\FooterForm;
use Narsil\Cms\Contracts\Requests\FooterFormRequest;
use Narsil\Cms\Models\Globals\Footer;

#endregion

final class FooterDefinition extends AbstractModelDefinition
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function form(): ?string
    {
        return FooterForm::class;
    }

    /**
     * {@inheritDoc}
     */
    public function indexWith(): array
    {
        return [
            Footer::RELATION_WEBSITES,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function indexWithCount(): array
    {
        return [
            Footer::RELATION_LINKS,
            Footer::RELATION_SOCIAL_MEDIA,
            Footer::RELATION_WEBSITES,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function model(): string
    {
        return Footer::class;
    }

    /**
     * {@inheritDoc}
     */
    public function operations(): array
    {
        return [
            Operation::CREATE,
            Operation::DESTROY,
            Operation::DESTROY_MANY,
            Operation::EDIT,
            Operation::INDEX,
            Operation::REPLICATE,
            Operation::STORE,
            Operation::UPDATE,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function replicateAction(): ?string
    {
        return ReplicateFooter::class;
    }

    /**
     * {@inheritDoc}
     */
    public function request(): ?string
    {
        return FooterFormRequest::class;
    }

    /**
     * {@inheritDoc}
     */
    public function route(): string
    {
        return 'footers';
    }

    #endregion
}
