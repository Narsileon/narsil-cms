<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Enums\Fields\VisibilityEnum;
use Narsil\Models\Fields\Field;
use Narsil\Models\Fields\FieldCondition;
use Narsil\Models\Fields\FieldSet;
use Narsil\Models\Fields\FieldSetElement;

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
            $this->createFieldSetsTable();
        }
        if (!Schema::hasTable(FieldSetElement::TABLE))
        {
            $this->createFieldSetElementTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(FieldSetElement::TABLE);
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
    private function createFieldSetElementTable(): void
    {
        Schema::create(FieldSetElement::TABLE, function (Blueprint $table)
        {
            $table
                ->id(FieldSetElement::ID);
            $table
                ->foreignId(FieldSetElement::FIELD_SET_ID)
                ->constrained(FieldSet::TABLE, FieldSet::ID)
                ->cascadeOnDelete();
            $table
                ->morphs(FieldSetElement::RELATION_ELEMENT);
            $table
                ->integer(FieldSetElement::POSITION)
                ->nullable();
        });
    }

    /**
     * @return void
     */
    private function createFieldSetsTable(): void
    {
        Schema::create(FieldSet::TABLE, function (Blueprint $table)
        {
            $table
                ->id(FieldSet::ID);
            $table
                ->string(Field::HANDLE);
            $table
                ->string(Field::NAME);
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
                ->string(Field::ICON)
                ->nullable();
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
