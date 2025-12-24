<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\ValidationRule;

#endregion

return new class extends Migration
{
    #region PUBLIC METHODS

    /**
     * Run the migrations.
     *
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
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(ValidationRule::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the validation rules table.
     *
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
