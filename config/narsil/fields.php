<?php

#region USE

use Narsil\Base\Enums\InputTypeEnum;

#endregion

return [

    /*
    |--------------------------------------------------------------------------
    | Available Fields
    |--------------------------------------------------------------------------
    |
    | Field contracts available in cms.
    |
    */

    InputTypeEnum::ARRAY->value => \Narsil\Base\Http\Data\Forms\Inputs\ArrayInputData::class,
    InputTypeEnum::CHECKBOX->value => \Narsil\Base\Http\Data\Forms\Inputs\CheckboxInputData::class,
    InputTypeEnum::DATE->value => \Narsil\Base\Http\Data\Forms\Inputs\DateInputData::class,
    InputTypeEnum::DATETIME->value => \Narsil\Base\Http\Data\Forms\Inputs\DatetimeInputData::class,
    InputTypeEnum::EMAIL->value => \Narsil\Base\Http\Data\Forms\Inputs\EmailInputData::class,
    InputTypeEnum::FILE->value => \Narsil\Base\Http\Data\Forms\Inputs\FileInputData::class,
    InputTypeEnum::NUMBER->value => \Narsil\Base\Http\Data\Forms\Inputs\NumberInputData::class,
    InputTypeEnum::PASSWORD->value => \Narsil\Base\Http\Data\Forms\Inputs\PasswordInputData::class,
    InputTypeEnum::RANGE->value => \Narsil\Base\Http\Data\Forms\Inputs\RangeInputData::class,
    InputTypeEnum::SELECT->value => \Narsil\Base\Http\Data\Forms\Inputs\SelectInputData::class,
    InputTypeEnum::SWITCH->value => \Narsil\Base\Http\Data\Forms\Inputs\SwitchInputData::class,
    InputTypeEnum::TABLE->value => \Narsil\Base\Http\Data\Forms\Inputs\TableInputData::class,
    InputTypeEnum::TEXT->value => \Narsil\Base\Http\Data\Forms\Inputs\TextInputData::class,
    InputTypeEnum::TEXTAREA->value => \Narsil\Base\Http\Data\Forms\Inputs\TextareaInputData::class,
    InputTypeEnum::TIME->value => \Narsil\Base\Http\Data\Forms\Inputs\TimeInputData::class,
];
