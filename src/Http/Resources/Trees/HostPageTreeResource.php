<?php

namespace Narsil\Http\Resources\Trees;

#region USE

use Illuminate\Http\Request;
use Narsil\Http\Resources\AbstractTreeResource;
use Narsil\Models\Hosts\HostPage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostPageTreeResource extends AbstractTreeResource
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            ...parent::toArray($request),

            HostPage::TITLE => $this->{HostPage::TITLE},

            self::CREATE_URL => route('host-pages.create', [
                HostPage::HOST_ID => $this->{HostPage::HOST_ID},
                HostPage::PARENT_ID => $this->{HostPage::ID},
            ]),
            self::EDIT_URL => route('host-pages.edit', $this->{HostPage::ID}),
        ];
    }

    #endregion
}
