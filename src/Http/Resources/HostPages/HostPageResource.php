<?php

namespace Narsil\Http\Resources\HostPages;

#region USE

use Illuminate\Http\Request;
use Narsil\Http\Resources\NestedTreeResource;
use Narsil\Models\Hosts\HostPage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostPageResource extends NestedTreeResource
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            ...parent::toArray($request),

            self::CREATE_URL => route('host-pages.create', [
                HostPage::HOST_ID => $this->{HostPage::HOST_ID},
                HostPage::PARENT_ID => $this->{HostPage::ID},
            ]),
            self::EDIT_URL => route('host-pages.edit', $this->{HostPage::ID}),
            self::LABEL => $this->{HostPage::TITLE} . ' (' . $this->{HostPage::ID} . ')',
        ];
    }

    #endregion
}
