<?php

namespace Narsil\Cms\Services\Models;

#region USE

use Narsil\Cms\Models\Forms\Input;
use Narsil\Cms\Models\Forms\InputOption;
use Narsil\Cms\Models\ValidationRule;
use Narsil\Cms\Services\DatabaseService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class InputService
{
    #region PUBLIC METHODS

    /**
     * @param Input $input
     *
     * @return void
     */
    public static function replicate(Input $input): void
    {
        $replicated = $input->replicate();

        $replicated
            ->fill([
                Input::HANDLE => DatabaseService::generateUniqueValue($replicated, Input::HANDLE, $input->{Input::HANDLE}),
            ])
            ->save();

        static::syncInputOptions($replicated, $input->options()->get()->toArray());

        $replicated->validation_rules()->sync($input->{Input::RELATION_VALIDATION_RULES}->pluck(ValidationRule::ID)->toArray());
    }

    /**
     * @param Input $input
     * @param array $options
     *
     * @return void
     */
    public static function syncInputOptions(Input $input, array $options): void
    {
        $uuids = [];

        foreach ($options as $key => $option)
        {
            $inputOption = InputOption::updateOrCreate([
                InputOption::INPUT_ID => $input->{Input::ID},
                InputOption::VALUE => $option[InputOption::VALUE],
            ], [
                InputOption::POSITION => $key,
                InputOption::LABEL => $option[InputOption::LABEL],
            ]);

            $uuids[] = $inputOption->{InputOption::UUID};
        }

        $input
            ->options()
            ->whereNotIn(InputOption::UUID, $uuids)
            ->delete();
    }

    #endregion
}
