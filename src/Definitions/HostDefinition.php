<?php

declare(strict_types=1);

namespace Narsil\Cms\Definitions;

#region USE

use Narsil\Base\Definitions\AbstractModelDefinition;
use Narsil\Base\Enums\ModelHookEventEnum;
use Narsil\Cms\Contracts\Actions\Hosts\ReplicateHost;
use Narsil\Cms\Contracts\Forms\HostForm;
use Narsil\Cms\Contracts\Requests\HostFormRequest;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Implementations\Tables\HostTable;
use Narsil\Cms\Implementations\Hooks\Hosts\DispatchHostSitemapHook;
use Narsil\Cms\Implementations\Hooks\Hosts\SyncHostLocalesHook;

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

    public function hooks(): array
    {
        return [
            ModelHookEventEnum::AFTER_STORE->value => [
                ['hook' => SyncHostLocalesHook::class, 'priority' => 0],
            ],
            ModelHookEventEnum::AFTER_UPDATE->value => [
                ['hook' => DispatchHostSitemapHook::class, 'priority' => 0],
                ['hook' => SyncHostLocalesHook::class, 'priority' => 0],
            ],
        ];
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

    public function morph(): ?string
    {
        return Host::TABLE;
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

    public function table(): ?string
    {
        return HostTable::class;
    }

    #endregion
}
