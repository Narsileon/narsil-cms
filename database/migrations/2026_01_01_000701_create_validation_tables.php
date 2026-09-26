<?php

declare(strict_types=1);

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Cms\Models\ValidationRule;

#endregion

return new class() extends Migration
{
    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable(ValidationRule::TABLE))
        {
            $this->createValidationRulesTable();
        }
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(ValidationRule::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createValidationRulesTable(): void
    {
        Schema::create(ValidationRule::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(ValidationRule::ID);
            $blueprint
                ->string(ValidationRule::HANDLE);
            $blueprint
                ->timestamps();
        });
    }

    #endregion
};
