<?php

namespace Narsil\Services\Models;

#region USE

use Narsil\Models\Forms\FormInput;
use Narsil\Models\Forms\FormInputOption;
use Narsil\Services\DatabaseService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class FormInputService
{
    #region PUBLIC METHODS

    /**
     * @param FormInput $input
     *
     * @return void
     */
    public static function replicateFormInput(FormInput $input): void
    {
        $replicated = $input->replicate();

        $replicated
            ->fill([
                FormInput::HANDLE => DatabaseService::generateUniqueValue($replicated, FormInput::HANDLE, $input->{FormInput::HANDLE}),
            ])
            ->save();

        static::syncFormInputOptions($replicated, $input->options()->get()->toArray());
    }

    /**
     * @param FormInput $formInput
     * @param array $options
     *
     * @return void
     */
    public static function syncFormInputOptions(FormInput $formInput, array $options): void
    {
        $uuids = [];

        foreach ($options as $key => $option)
        {
            $formInputOption = FormInputOption::updateOrCreate([
                FormInputOption::INPUT_ID => $formInput->{FormInput::ID},
                FormInputOption::VALUE => $option[FormInputOption::VALUE],
            ], [
                FormInputOption::POSITION => $key,
                FormInputOption::LABEL => $option[FormInputOption::LABEL],
            ]);

            $uuids[] = $formInputOption->{FormInputOption::UUID};
        }

        $formInput
            ->options()
            ->whereNotIn(FormInputOption::UUID, $uuids)
            ->delete();
    }

    #endregion
}
