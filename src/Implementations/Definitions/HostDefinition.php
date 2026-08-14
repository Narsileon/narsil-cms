<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Definitions;

#region USE

use Narsil\Base\Resources\AbstractModelDefinition;
use Narsil\Cms\Contracts\Actions\Hosts\ReplicateHost;
use Narsil\Cms\Contracts\Forms\HostForm;
use Narsil\Cms\Contracts\Requests\HostFormRequest;
use Narsil\Cms\Models\Hosts\Host;

#endregion

final class HostDefinition extends AbstractModelDefinition
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function editWith(): array
    {
        return [
            Host::RELATION_LOCALES,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function form(): ?string
    {
        return HostForm::class;
    }

    /**
     * {@inheritDoc}
     */
    public function indexWith(): array
    {
        return [
            Host::RELATION_LOCALES,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function model(): string
    {
        return Host::class;
    }

    /**
     * {@inheritDoc}
     */
    public function replicateAction(): ?string
    {
        return ReplicateHost::class;
    }

    /**
     * {@inheritDoc}
     */
    public function request(): ?string
    {
        return HostFormRequest::class;
    }

    /**
     * {@inheritDoc}
     */
    public function route(): string
    {
        return 'hosts';
    }

    #endregion
}
