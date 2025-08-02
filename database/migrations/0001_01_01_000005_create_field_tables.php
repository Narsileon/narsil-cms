<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\FieldOption;

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
        if (!Schema::hasTable(Field::TABLE))
        {
            $this->createFieldsTable();
        }
        if (!Schema::hasTable(FieldOption::TABLE))
        {
            $this->createFieldOptionsTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(FieldOption::TABLE);
        Schema::dropIfExists(Field::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createFieldOptionsTable(): void
    {
        Schema::create(FieldOption::TABLE, function (Blueprint $table)
        {
            $table
                ->id(FieldOption::ID);
            $table
                ->foreignId(FieldOption::FIELD_ID)
                ->constrained(Field::TABLE, Field::ID)
                ->cascadeOnDelete();
            $table
                ->string(FieldOption::LABEL);
            $table
                ->string(FieldOption::VALUE);
            $table
                ->timestamps();
        });
    }

    /**
     * @return void
     */
    private function createFieldsTable(): void
    {
        Schema::create(Field::TABLE, function (Blueprint $table)
        {
            $table
                ->id(Field::ID);
            $table
                ->string(Field::HANDLE);
            $table
                ->string(Field::NAME);
            $table
                ->string(Field::DESCRIPTION)
                ->nullable();
            $table
                ->boolean(Field::TRANSLATABLE)
                ->default(false);
            $table
                ->string(Field::TYPE);
            $table
                ->json(Field::SETTINGS)
                ->nullable()
                ->default(null);
            $table
                ->timestamps();
        });
    }

    #endregion
};
