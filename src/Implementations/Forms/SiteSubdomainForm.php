<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\ArrayField;
use Narsil\Contracts\Fields\TableField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\SiteSubdomainForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Sites\SiteSubdomain;
use Narsil\Models\Sites\SiteSubdomainLanguage;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class SiteSubdomainForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function layout(): array
    {
        return [
            new Field([
                Field::HANDLE => SiteSubdomain::SUBDOMAIN,
                Field::NAME => trans('narsil::validation.attributes.subdomain'),
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => SiteSubdomain::RELATION_LANGUAGES,
                Field::NAME => trans('narsil::validation.attributes.languages'),
                Field::TYPE => TableField::class,
                Field::SETTINGS => app(TableField::class)
                    ->setColumns([
                        new Field([
                            Field::HANDLE => SiteSubdomainLanguage::LANGUAGE,
                            Field::NAME => trans('narsil::validation.attributes.language'),
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->setRequired(true),
                        ]),
                    ])
                    ->setPlaceholder(trans('narsil::ui.add')),
            ]),
        ];
    }

    #endregion
}
