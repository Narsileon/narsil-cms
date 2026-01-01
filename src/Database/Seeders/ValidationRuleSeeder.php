<?php

namespace Narsil\Database\Seeders;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Enums\ValidationRuleEnum;
use Narsil\Models\ValidationRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ValidationRuleSeeder extends Seeder
{
    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function run(): void
    {
        $this->syncValidationRules();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return void
     */
    protected function syncValidationRules(): void
    {
        foreach (ValidationRuleEnum::cases() as $case)
        {
            ValidationRule::firstOrCreate([
                ValidationRule::HANDLE => $case->value,
            ]);
        }
    }

    #endregion
}
