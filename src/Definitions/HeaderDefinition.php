<?php

declare(strict_types=1);

namespace Narsil\Cms\Definitions;

#region USE

use Narsil\Base\Definitions\AbstractModelDefinition;
use Narsil\Base\Enums\ModelOperationEnum;
use Narsil\Cms\Contracts\Actions\Headers\ReplicateHeader;
use Narsil\Cms\Contracts\Forms\HeaderForm;
use Narsil\Cms\Contracts\Requests\HeaderFormRequest;
use Narsil\Cms\Implementations\Tables\HeaderTable;
use Narsil\Cms\Models\Globals\Header;

#endregion

final class HeaderDefinition extends AbstractModelDefinition
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function form(): ?string
    {
        return HeaderForm::class;
    }

    /**
     * {@inheritDoc}
     */
    public function indexWith(): array
    {
        return [
            Header::RELATION_WEBSITES,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function indexWithCount(): array
    {
        return [
            Header::RELATION_WEBSITES,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function model(): string
    {
        return Header::class;
    }

    public function morph(): ?string
    {
        return Header::TABLE;
    }

    /**
     * {@inheritDoc}
     */
    public function operations(): array
    {
        return [
            ModelOperationEnum::CREATE,
            ModelOperationEnum::DESTROY,
            ModelOperationEnum::DESTROY_MANY,
            ModelOperationEnum::EDIT,
            ModelOperationEnum::INDEX,
            ModelOperationEnum::REPLICATE,
            ModelOperationEnum::STORE,
            ModelOperationEnum::UPDATE,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function replicateAction(): ?string
    {
        return ReplicateHeader::class;
    }

    /**
     * {@inheritDoc}
     */
    public function request(): ?string
    {
        return HeaderFormRequest::class;
    }

    /**
     * {@inheritDoc}
     */
    public function route(): string
    {
        return 'headers';
    }

    public function table(): ?string
    {
        return HeaderTable::class;
    }

    #endregion
}
