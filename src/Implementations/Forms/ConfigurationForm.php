<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Forms\ConfigurationForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Configuration;
use Narsil\Models\Elements\Field;
use Narsil\Services\RouteService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConfigurationForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->routes(RouteService::getNames(Configuration::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        return [
            new Field([
                Field::HANDLE => Configuration::DEFAULT_LANGUAGE,
                Field::NAME => trans('narsil::validation.attributes.default_language'),
                Field::TYPE => SelectField::class,
                Field::RELATION_OPTIONS => [],
                Field::SETTINGS => app(SelectField::class)
                    ->required(true),
            ]),
        ];
    }

    #endregion
}
