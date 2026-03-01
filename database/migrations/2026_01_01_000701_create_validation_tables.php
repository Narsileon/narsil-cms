<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Models\ValidationRule;

#endregion

return new class extends Migration
{
    use HasSchemas;

    #region PUBLIC METHODS

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $schema = $this->getFallbackSchema();

        if (!Schema::hasTable("$schema." . ValidationRule::TABLE))
        {
            $this->createValidationRulesTable($schema);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $schema = $this->getFallbackSchema();

        Schema::dropIfExists("$schema." . ValidationRule::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the validation rules table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createValidationRulesTable(string $schema): void
    {
        Schema::create("$schema." . ValidationRule::TABLE, function (Blueprint $blueprint)
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
