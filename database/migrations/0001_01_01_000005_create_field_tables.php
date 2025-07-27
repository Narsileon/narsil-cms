<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Enums\Fields\VisibilityEnum;
use Narsil\Models\Fields\Field;
use Narsil\Models\Fields\FieldCondition;
use Narsil\Models\Fields\FieldSet;

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
        if (!Schema::hasTable(FieldCondition::TABLE))
        {
            $this->createFieldConditionsTable();
        }
        if (!Schema::hasTable(FieldSet::TABLE))
        {
            $this->createFieldSetTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(FieldSet::TABLE);
        Schema::dropIfExists(FieldCondition::TABLE);
        Schema::dropIfExists(Field::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createFieldConditionsTable(): void
    {
        Schema::create(FieldCondition::TABLE, function (Blueprint $table)
        {
            $table
                ->id(FieldCondition::ID);
            $table
                ->foreignId(FieldCondition::OWNER_ID)
                ->constrained(Field::TABLE, Field::ID)
                ->cascadeOnDelete();
            $table
                ->foreignId(FieldCondition::TARGET_ID)
                ->constrained(Field::TABLE, Field::ID)
                ->cascadeOnDelete();
            $table
                ->string(FieldCondition::OPERATOR);
            $table
                ->string(FieldCondition::VALUE);
            $table
                ->timestamps();
        });
    }

    /**
     * @return void
     */
    private function createFieldSetTable(): void
    {
        Schema::create(FieldSet::TABLE, function (Blueprint $table)
        {
            $table
                ->id(FieldSet::ID);
            $table
                ->foreignId(FieldSet::FIELD_ID)
                ->constrained(Field::TABLE, Field::ID)
                ->cascadeOnDelete();
            $table
                ->foreignId(FieldSet::SET_ID)
                ->constrained(Field::TABLE, Field::ID)
                ->cascadeOnDelete();
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
                ->foreignId(Field::PARENT_ID)
                ->nullable()
                ->constrained(Field::TABLE, Field::ID)
                ->nullOnDelete();
            $table
                ->integer(Field::INDEX)
                ->nullable();
            $table
                ->string(Field::NAME);
            $table
                ->string(Field::HANDLE);
            $table
                ->string(Field::TYPE);
            $table
                ->string(Field::VISIBILITY)
                ->default(VisibilityEnum::DISPLAY->value);
            $table
                ->string(Field::WIDTH)
                ->nullable();
            $table
                ->json(Field::SETTINGS)
                ->default(json_encode([]));
            $table
                ->timestamps();
        });
    }

    #endregion
};
