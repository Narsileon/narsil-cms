<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Cms\Enums\Database\OperatorEnum;
use Narsil\Cms\Models\Forms\Fieldset;
use Narsil\Cms\Models\Forms\FieldsetElement;
use Narsil\Cms\Models\Forms\FieldsetElementCondition;
use Narsil\Cms\Models\Forms\Form;
use Narsil\Cms\Models\Forms\FormSubmission;
use Narsil\Cms\Models\Forms\FormStep;
use Narsil\Cms\Models\Forms\FormStepElement;
use Narsil\Cms\Models\Forms\FormStepElementCondition;
use Narsil\Cms\Models\Forms\FormWebhook;
use Narsil\Cms\Models\Forms\Input;
use Narsil\Cms\Models\Forms\InputOption;
use Narsil\Cms\Models\Forms\InputValidationRule;
use Narsil\Cms\Models\User;
use Narsil\Cms\Models\ValidationRule;

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
        if (!Schema::hasTable(FormStep::TABLE))
        {
            $this->createFormStepsTable();
        }
        if (!Schema::hasTable(FormStepElement::TABLE))
        {
            $this->createFormStepElementTable();
        }
        if (!Schema::hasTable(FormStepElementCondition::TABLE))
        {
            $this->createFormStepElementConditionsTable();
        }
        if (!Schema::hasTable(FormSubmission::TABLE))
        {
            $this->createFormSubmissionsTable();
        }
        if (!Schema::hasTable(FormWebhook::TABLE))
        {
            $this->createFormWebhooksTable();
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

        Schema::dropIfExists(FormWebhook::TABLE);
        Schema::dropIfExists(FormSubmission::TABLE);
        Schema::dropIfExists(FormStepElementCondition::TABLE);
        Schema::dropIfExists(FormStepElement::TABLE);
        Schema::dropIfExists(FormStep::TABLE);
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
                ->integer(FieldsetElementCondition::POSITION)
                ->default(0)
                ->index();
            $blueprint
                ->string(FieldsetElementCondition::HANDLE);
            $blueprint
                ->enum(FieldsetElementCondition::OPERATOR, OperatorEnum::values())
                ->default(OperatorEnum::EQUALS);
            $blueprint
                ->string(FieldsetElementCondition::VALUE);
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
                ->morphs(FieldsetElement::RELATION_BASE);
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
                ->jsonb(FieldsetElement::LABEL);
            $blueprint
                ->jsonb(FieldsetElement::DESCRIPTION)
                ->nullable();
            $blueprint
                ->boolean(FieldsetElement::REQUIRED)
                ->default(false);
            $blueprint
                ->integer(FieldsetElement::POSITION)
                ->default(0)
                ->index();
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
                ->jsonb(Fieldset::LABEL);
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
     * Create the form submissions table.
     *
     * @return void
     */
    private function createFormSubmissionsTable(): void
    {
        Schema::create(FormSubmission::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FormSubmission::UUID)
                ->primary();
            $blueprint
                ->foreignId(FormSubmission::FORM_ID)
                ->constrained(Form::TABLE, Form::ID)
                ->cascadeOnDelete();
            $blueprint
                ->json(FormSubmission::DATA);
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the form step element conditions table.
     *
     * @return void
     */
    private function createFormStepElementConditionsTable(): void
    {
        Schema::create(FormStepElementCondition::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FormStepElementCondition::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(FormStepElementCondition::FORM_STEP_ELEMENT_UUID)
                ->constrained(FormStepElement::TABLE, FormStepElement::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->integer(FieldsetElementCondition::POSITION)
                ->default(0)
                ->index();
            $blueprint
                ->string(FormStepElementCondition::HANDLE);
            $blueprint
                ->enum(FormStepElementCondition::OPERATOR, OperatorEnum::values())
                ->default(OperatorEnum::EQUALS);
            $blueprint
                ->string(FormStepElementCondition::VALUE);
        });
    }

    /**
     * Create the form step elements table.
     *
     * @return void
     */
    private function createFormStepElementTable(): void
    {
        Schema::create(FormStepElement::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FormStepElement::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(FormStepElement::OWNER_UUID)
                ->constrained(FormStep::TABLE, FormStep::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->morphs(FormStepElement::RELATION_BASE);
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
                ->string(FormStepElement::HANDLE);
            $blueprint
                ->jsonb(FormStepElement::LABEL);
            $blueprint
                ->jsonb(FormStepElement::DESCRIPTION)
                ->nullable();
            $blueprint
                ->boolean(FormStepElement::REQUIRED)
                ->default(false);
            $blueprint
                ->integer(FormStepElement::POSITION)
                ->default(0)
                ->index();
            $blueprint
                ->smallInteger(FormStepElement::WIDTH)
                ->default(100);
        });
    }

    /**
     * Create the form steps table.
     *
     * @return void
     */
    private function createFormStepsTable(): void
    {
        Schema::create(FormStep::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FormStep::UUID)
                ->primary();
            $blueprint
                ->foreignId(FormStep::FORM_ID)
                ->constrained(Form::TABLE, Form::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(FormStep::HANDLE);
            $blueprint
                ->jsonb(FormStep::LABEL);
            $blueprint
                ->jsonb(FormStep::DESCRIPTION)
                ->nullable();
            $blueprint
                ->integer(FormStep::POSITION)
                ->default(0)
                ->index();
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
                ->string(Form::SLUG)
                ->unique();
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
     * Create the form webhooks table.
     *
     * @return void
     */
    private function createFormWebhooksTable(): void
    {
        Schema::create(FormWebhook::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FormWebhook::UUID)
                ->primary();
            $blueprint
                ->foreignId(FormWebhook::FORM_ID)
                ->constrained(Form::TABLE, Form::ID)
                ->cascadeOnDelete();
            $blueprint
                ->integer(FormWebhook::POSITION)
                ->default(0)
                ->index();
            $blueprint
                ->string(FormWebhook::URL);
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
                ->default(0)
                ->index();
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
                ->jsonb(Input::LABEL);
            $blueprint
                ->jsonb(Input::DESCRIPTION)
                ->nullable();
            $blueprint
                ->jsonb(Input::PLACEHOLDER)
                ->nullable();
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
