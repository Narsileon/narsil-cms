<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\FieldsetElement;
use Narsil\Models\Forms\FieldsetElementCondition;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\FormTab;
use Narsil\Models\Forms\FormTabElement;
use Narsil\Models\Forms\FormTabElementCondition;
use Narsil\Models\Forms\Input;
use Narsil\Models\Forms\InputOption;
use Narsil\Models\Forms\InputValidationRule;
use Narsil\Models\User;
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
        if (!Schema::hasTable(Input::TABLE))
        {
            $this->createInputsTable();
        }
        if (!Schema::hasTable(InputOption::TABLE))
        {
            $this->createInputOptionsTable();
        }
        if (!Schema::hasTable(InputValidationRule::TABLE))
        {
            $this->createInputValidationRuleTable();
        }

        if (!Schema::hasTable(Fieldset::TABLE))
        {
            $this->createFieldsetsTable();
        }
        if (!Schema::hasTable(FieldsetElement::TABLE))
        {
            $this->createFieldsetElementTable();
        }
        if (!Schema::hasTable(FieldsetElementCondition::TABLE))
        {
            $this->createFieldsetElementConditionsTable();
        }

        if (!Schema::hasTable(Form::TABLE))
        {
            $this->createFormsTable();
        }
        if (!Schema::hasTable(FormTab::TABLE))
        {
            $this->createFormTabsTable();
        }
        if (!Schema::hasTable(FormTabElement::TABLE))
        {
            $this->createFormTabElementTable();
        }
        if (!Schema::hasTable(FormTabElementCondition::TABLE))
        {
            $this->createFormTabElementConditionsTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(InputValidationRule::TABLE);
        Schema::dropIfExists(InputOption::TABLE);
        Schema::dropIfExists(Input::TABLE);

        Schema::dropIfExists(FieldsetElementCondition::TABLE);
        Schema::dropIfExists(FieldsetElement::TABLE);
        Schema::dropIfExists(Fieldset::TABLE);

        Schema::dropIfExists(FormTabElementCondition::TABLE);
        Schema::dropIfExists(FormTabElement::TABLE);
        Schema::dropIfExists(FormTab::TABLE);
        Schema::dropIfExists(Form::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the fieldset element conditions table.
     *
     * @return void
     */
    private function createFieldsetElementConditionsTable(): void
    {
        Schema::create(FieldsetElementCondition::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FieldsetElementCondition::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(FieldsetElementCondition::FIELDSET_ELEMENT_UUID)
                ->constrained(FieldsetElement::TABLE, FieldsetElement::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->string(FieldsetElementCondition::HANDLE);
            $blueprint
                ->string(FieldsetElementCondition::OPERATOR);
            $blueprint
                ->string(FieldsetElementCondition::VALUE);
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the form fieldset elements table.
     *
     * @return void
     */
    private function createFieldsetElementTable(): void
    {
        Schema::create(FieldsetElement::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FieldsetElement::UUID)
                ->primary();
            $blueprint
                ->foreignId(FieldsetElement::OWNER_ID)
                ->constrained(Fieldset::TABLE, Fieldset::ID)
                ->cascadeOnDelete();
            $blueprint
                ->morphs(FieldsetElement::RELATION_ELEMENT);
            $blueprint
                ->foreignId(FieldsetElement::FIELDSET_ID)
                ->nullable()
                ->constrained(Fieldset::TABLE, Fieldset::ID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(FieldsetElement::INPUT_ID)
                ->nullable()
                ->constrained(Input::TABLE, Input::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(FieldsetElement::HANDLE);
            $blueprint
                ->jsonb(FieldsetElement::NAME);
            $blueprint
                ->jsonb(FieldsetElement::DESCRIPTION)
                ->nullable();
            $blueprint
                ->boolean(FieldsetElement::REQUIRED)
                ->nullable();
            $blueprint
                ->boolean(FieldsetElement::TRANSLATABLE)
                ->nullable();
            $blueprint
                ->integer(FieldsetElement::POSITION)
                ->default(0);
            $blueprint
                ->smallInteger(FieldsetElement::WIDTH)
                ->default(100);
        });
    }

    /**
     * Create the form fieldsets table.
     *
     * @return void
     */
    private function createFieldsetsTable(): void
    {
        Schema::create(Fieldset::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Fieldset::ID);
            $blueprint
                ->string(Fieldset::HANDLE)
                ->unique();
            $blueprint
                ->jsonb(Fieldset::NAME);
            $blueprint
                ->timestamp(Fieldset::CREATED_AT);
            $blueprint
                ->foreignId(Fieldset::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamp(Fieldset::UPDATED_AT);
            $blueprint
                ->foreignId(Fieldset::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
        });
    }

    /**
     * Create the form tab element conditions table.
     *
     * @return void
     */
    private function createFormTabElementConditionsTable(): void
    {
        Schema::create(FormTabElementCondition::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FormTabElementCondition::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(FormTabElementCondition::FORM_TAB_ELEMENT_UUID)
                ->constrained(FormTabElement::TABLE, FormTabElement::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->string(FormTabElementCondition::HANDLE);
            $blueprint
                ->string(FormTabElementCondition::OPERATOR);
            $blueprint
                ->string(FormTabElementCondition::VALUE);
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the form tab elements table.
     *
     * @return void
     */
    private function createFormTabElementTable(): void
    {
        Schema::create(FormTabElement::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FormTabElement::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(FormTabElement::OWNER_UUID)
                ->constrained(FormTab::TABLE, FormTab::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->morphs(FormTabElement::RELATION_ELEMENT);
            $blueprint
                ->foreignId(FieldsetElement::FIELDSET_ID)
                ->nullable()
                ->constrained(Fieldset::TABLE, Fieldset::ID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(FieldsetElement::INPUT_ID)
                ->nullable()
                ->constrained(Input::TABLE, Input::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(FormTabElement::HANDLE);
            $blueprint
                ->jsonb(FormTabElement::NAME);
            $blueprint
                ->jsonb(FormTabElement::DESCRIPTION)
                ->nullable();
            $blueprint
                ->boolean(FormTabElement::REQUIRED)
                ->nullable();
            $blueprint
                ->boolean(FormTabElement::TRANSLATABLE)
                ->nullable();
            $blueprint
                ->integer(FormTabElement::POSITION)
                ->default(0);
            $blueprint
                ->smallInteger(FormTabElement::WIDTH)
                ->default(100);
        });
    }

    /**
     * Create the form tabs table.
     *
     * @return void
     */
    private function createFormTabsTable(): void
    {
        Schema::create(FormTab::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FormTab::UUID)
                ->primary();
            $blueprint
                ->foreignId(FormTab::FORM_ID)
                ->constrained(Form::TABLE, Form::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(FormTab::HANDLE);
            $blueprint
                ->jsonb(FormTab::NAME);
            $blueprint
                ->integer(FormTab::POSITION)
                ->default(0);
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the forms table.
     *
     * @return void
     */
    private function createFormsTable(): void
    {
        Schema::create(Form::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Form::ID);
            $blueprint
                ->string(Form::HANDLE)
                ->unique();
            $blueprint
                ->jsonb(Form::TITLE);
            $blueprint
                ->jsonb(Form::DESCRIPTION);
            $blueprint
                ->timestamp(Form::CREATED_AT);
            $blueprint
                ->foreignId(Form::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamp(Form::UPDATED_AT);
            $blueprint
                ->foreignId(Form::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
        });
    }

    /**
     * Create the input options table.
     *
     * @return void
     */
    private function createInputOptionsTable(): void
    {
        Schema::create(InputOption::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(InputOption::UUID)
                ->primary();
            $blueprint
                ->foreignId(InputOption::INPUT_ID)
                ->constrained(Input::TABLE, Input::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(InputOption::VALUE);
            $blueprint
                ->jsonb(InputOption::LABEL);
            $blueprint
                ->integer(InputOption::POSITION)
                ->default(0);
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the input validation rule table.
     *
     * @return void
     */
    private function createInputValidationRuleTable(): void
    {
        Schema::create(InputValidationRule::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(InputValidationRule::UUID)
                ->primary();
            $blueprint
                ->foreignId(InputValidationRule::INPUT_ID)
                ->constrained(Input::TABLE, Input::ID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(InputValidationRule::VALIDATION_RULE_ID)
                ->constrained(ValidationRule::TABLE, ValidationRule::ID)
                ->cascadeOnDelete();
        });
    }

    /**
     * Create the inputs table.
     *
     * @return void
     */
    private function createInputsTable(): void
    {
        Schema::create(Input::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Input::ID);
            $blueprint
                ->string(Input::HANDLE)
                ->unique();
            $blueprint
                ->string(Input::TYPE);
            $blueprint
                ->jsonb(Input::NAME);
            $blueprint
                ->jsonb(Input::DESCRIPTION)
                ->nullable();
            $blueprint
                ->boolean(Input::REQUIRED)
                ->default(false);
            $blueprint
                ->jsonb(Input::SETTINGS)
                ->nullable();
            $blueprint
                ->timestamp(Input::CREATED_AT);
            $blueprint
                ->foreignId(Input::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamp(Input::UPDATED_AT);
            $blueprint
                ->foreignId(Input::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
        });
    }

    #endregion
};
