<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Enums\Forms\RuleEnum;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\FormFieldset;
use Narsil\Models\Forms\FormFieldsetElement;
use Narsil\Models\Forms\FormInput;
use Narsil\Models\Forms\FormInputOption;
use Narsil\Models\Forms\FormInputRule;
use Narsil\Models\Forms\FormPage;
use Narsil\Models\Forms\FormPageElement;
use Narsil\Models\User;

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
        if (!Schema::hasTable(FormInput::TABLE))
        {
            $this->createFormInputsTable();
        }
        if (!Schema::hasTable(FormInputOption::TABLE))
        {
            $this->createFormInputOptionsTable();
        }
        if (!Schema::hasTable(FormInputRule::TABLE))
        {
            $this->createFormInputRulesTable();
        }

        if (!Schema::hasTable(FormFieldset::TABLE))
        {
            $this->createFormFieldsetsTable();
        }
        if (!Schema::hasTable(FormFieldsetElement::TABLE))
        {
            $this->createFormFieldsetElementTable();
        }

        if (!Schema::hasTable(Form::TABLE))
        {
            $this->createFormsTable();
        }
        if (!Schema::hasTable(FormPage::TABLE))
        {
            $this->createFormPagesTable();
        }
        if (!Schema::hasTable(FormPageElement::TABLE))
        {
            $this->createFormPageElementTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(FormInputRule::TABLE);
        Schema::dropIfExists(FormInputOption::TABLE);
        Schema::dropIfExists(FormInput::TABLE);

        Schema::dropIfExists(FormFieldsetElement::TABLE);
        Schema::dropIfExists(FormFieldset::TABLE);

        Schema::dropIfExists(FormPageElement::TABLE);
        Schema::dropIfExists(FormPage::TABLE);
        Schema::dropIfExists(Form::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the form input options table.
     *
     * @return void
     */
    private function createFormInputOptionsTable(): void
    {
        Schema::create(FormInputOption::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FormInputOption::UUID)
                ->primary();
            $blueprint
                ->foreignId(FormInputOption::INPUT_ID)
                ->constrained(FormInput::TABLE, FormInput::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(FormInputOption::VALUE);
            $blueprint
                ->jsonb(FormInputOption::LABEL);
            $blueprint
                ->integer(FormInputOption::POSITION)
                ->default(0);
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the form input rules table.
     *
     * @return void
     */
    private function createFormInputRulesTable(): void
    {
        Schema::create(FormInputRule::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FormInputRule::UUID)
                ->primary();
            $blueprint
                ->foreignId(FormInputRule::INPUT_ID)
                ->constrained(FormInput::TABLE, FormInput::ID)
                ->cascadeOnDelete();
            $blueprint
                ->enum(FormInputRule::RULE, RuleEnum::values())
                ->default(RuleEnum::STRING->value);
        });
    }

    /**
     * Create the form inputs table.
     *
     * @return void
     */
    private function createFormInputsTable(): void
    {
        Schema::create(FormInput::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(FormInput::ID);
            $blueprint
                ->string(FormInput::HANDLE)
                ->unique();
            $blueprint
                ->string(FormInput::TYPE);
            $blueprint
                ->jsonb(FormInput::NAME);
            $blueprint
                ->jsonb(FormInput::DESCRIPTION)
                ->nullable();
            $blueprint
                ->boolean(FormInput::REQUIRED)
                ->default(false);
            $blueprint
                ->jsonb(FormInput::SETTINGS)
                ->nullable();
            $blueprint
                ->timestamp(FormInput::CREATED_AT);
            $blueprint
                ->foreignId(FormInput::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamp(FormInput::UPDATED_AT);
            $blueprint
                ->foreignId(FormInput::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
        });
    }

    /**
     * Create the form fieldset elements table.
     *
     * @return void
     */
    private function createFormFieldsetElementTable(): void
    {
        Schema::create(FormFieldsetElement::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(FormFieldsetElement::ID);
            $blueprint
                ->foreignId(FormFieldsetElement::FIELDSET_ID)
                ->constrained(FormFieldset::TABLE, FormFieldset::ID)
                ->cascadeOnDelete();
            $blueprint
                ->morphs(FormFieldsetElement::RELATION_ELEMENT);
            $blueprint
                ->string(FormFieldsetElement::HANDLE);
            $blueprint
                ->jsonb(FormFieldsetElement::NAME);
            $blueprint
                ->jsonb(FormFieldsetElement::DESCRIPTION)
                ->nullable();
            $blueprint
                ->boolean(FormFieldsetElement::REQUIRED)
                ->nullable();
            $blueprint
                ->boolean(FormFieldsetElement::TRANSLATABLE)
                ->nullable();
            $blueprint
                ->integer(FormFieldsetElement::POSITION)
                ->default(0);
            $blueprint
                ->smallInteger(FormFieldsetElement::WIDTH)
                ->default(100);
        });
    }

    /**
     * Create the form fieldsets table.
     *
     * @return void
     */
    private function createFormFieldsetsTable(): void
    {
        Schema::create(FormFieldset::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(FormFieldset::ID);
            $blueprint
                ->string(FormFieldset::HANDLE)
                ->unique();
            $blueprint
                ->jsonb(FormFieldset::NAME);
            $blueprint
                ->timestamp(FormFieldset::CREATED_AT);
            $blueprint
                ->foreignId(FormFieldset::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamp(FormFieldset::UPDATED_AT);
            $blueprint
                ->foreignId(FormFieldset::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
        });
    }

    /**
     * Create the form page elements table.
     *
     * @return void
     */
    private function createFormPageElementTable(): void
    {
        Schema::create(FormPageElement::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(FormPageElement::ID);
            $blueprint
                ->foreignId(FormPageElement::PAGE_ID)
                ->constrained(FormPage::TABLE, FormPage::ID)
                ->cascadeOnDelete();
            $blueprint
                ->morphs(FormPageElement::RELATION_ELEMENT);
            $blueprint
                ->string(FormPageElement::HANDLE);
            $blueprint
                ->jsonb(FormPageElement::NAME);
            $blueprint
                ->jsonb(FormPageElement::DESCRIPTION)
                ->nullable();
            $blueprint
                ->boolean(FormPageElement::REQUIRED)
                ->nullable();
            $blueprint
                ->boolean(FormPageElement::TRANSLATABLE)
                ->nullable();
            $blueprint
                ->integer(FormPageElement::POSITION)
                ->default(0);
            $blueprint
                ->smallInteger(FormPageElement::WIDTH)
                ->default(100);
        });
    }

    /**
     * Create the form pages table.
     *
     * @return void
     */
    private function createFormPagesTable(): void
    {
        Schema::create(FormPage::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(FormPage::ID);
            $blueprint
                ->foreignId(FormPage::FORM_ID)
                ->constrained(Form::TABLE, Form::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(FormPage::HANDLE);
            $blueprint
                ->jsonb(FormPage::NAME);
            $blueprint
                ->integer(FormPage::POSITION)
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

    #endregion
};
