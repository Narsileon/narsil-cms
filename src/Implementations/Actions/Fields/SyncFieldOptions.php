<?php

namespace Narsil\Cms\Implementations\Actions\Fields;

#region USE

use Illuminate\Support\Arr;
use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\Fields\SyncFieldOptions as Contract;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\FieldOption;

#endregion

/**
 * @author Jonathan Rigaux
 */
class SyncFieldOptions extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(Field $field, array $options): Field
    {
        $uuids = [];

        foreach ($options as $key => $option)
        {
            $fieldOption = FieldOption::updateOrCreate([
                FieldOption::FIELD_ID => $field->{Field::ID},
                FieldOption::VALUE => Arr::get($option, FieldOption::VALUE),
            ], [
                FieldOption::POSITION => $key,
                FieldOption::LABEL => Arr::get($option, FieldOption::LABEL),
            ]);

            $uuids[] = $fieldOption->{FieldOption::UUID};
        }

        $field
            ->options()
            ->whereNotIn(FieldOption::UUID, $uuids)
            ->delete();

        return $field;
    }

    #endregion
}
