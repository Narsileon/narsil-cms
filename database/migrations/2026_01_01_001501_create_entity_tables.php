<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityBlock;
use Narsil\Models\Entities\EntityField;
use Narsil\Models\Entities\EntityFieldEntity;
use Narsil\Models\Entities\EntityFieldForm;
use Narsil\Models\Entities\EntityFieldSitePage;
use Narsil\Models\Forms\Form;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\Template;
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
        if (!Schema::hasTable(Entity::TABLE))
        {
            $this->createEntitiesTable();
        }
        if (!Schema::hasTable(EntityField::TABLE))
        {
            $this->createEntityFieldsTable();
        }
        if (!Schema::hasTable(EntityBlock::TABLE))
        {
            $this->createEntityBlocksTable();
        }
        if (!Schema::hasTable(EntityFieldEntity::TABLE))
        {
            $this->createEntityFieldEntityTable();
        }
        if (!Schema::hasTable(EntityFieldForm::TABLE))
        {
            $this->createEntityFieldFormTable();
        }
        if (!Schema::hasTable(EntityFieldSitePage::TABLE))
        {
            $this->createEntityFieldSitePageTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(EntityFieldSitePage::TABLE);
        Schema::dropIfExists(EntityFieldForm::TABLE);
        Schema::dropIfExists(EntityFieldEntity::TABLE);
        Schema::dropIfExists(EntityBlock::TABLE);
        Schema::dropIfExists(EntityField::TABLE);
        Schema::dropIfExists(Entity::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the entities table.
     *
     * @return void
     */
    protected function createEntitiesTable(): void
    {
        Schema::create(Entity::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(Entity::UUID)
                ->primary();
            $blueprint
                ->bigInteger(Entity::ID)
                ->index();
            $blueprint
                ->foreignId(Entity::TEMPLATE_ID)
                ->constrained(Template::TABLE, Template::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(Entity::SLUG);
            $blueprint
                ->bigInteger(Entity::REVISION)
                ->default(1)
                ->index();
            $blueprint
                ->boolean(Entity::PUBLISHED)
                ->default(false)
                ->index();
            $blueprint
                ->dateTime(Entity::PUBLISHED_FROM)
                ->nullable();
            $blueprint
                ->dateTime(Entity::PUBLISHED_TO)
                ->nullable();
            $blueprint
                ->timestamp(Entity::CREATED_AT);
            $blueprint
                ->foreignId(Entity::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamp(Entity::UPDATED_AT);
            $blueprint
                ->foreignId(Entity::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->softDeletes()
                ->index();
            $blueprint
                ->foreignId(Entity::DELETED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
        });
    }

    /**
     * Create the entity fields table.
     *
     * @return void
     */
    protected function createEntityFieldsTable(): void
    {
        Schema::create(EntityField::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntityField::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntityField::ENTITY_UUID)
                ->constrained(Entity::TABLE, Entity::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->uuid(EntityField::ENTITY_BLOCK_UUID)
                ->nullable();
            $blueprint
                ->uuidMorphs(EntityField::RELATION_ELEMENT);
            $blueprint
                ->jsonb(EntityField::VALUE)
                ->nullable();
        });
    }

    /**
     * Create the entity blocks table.
     *
     * @return void
     */
    protected function createEntityBlocksTable(): void
    {
        Schema::create(EntityBlock::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntityBlock::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntityBlock::ENTITY_UUID)
                ->constrained(Entity::TABLE, Entity::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignUuid(EntityBlock::ENTITY_FIELD_UUID)
                ->constrained(EntityField::TABLE, EntityField::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->nullableUuidMorphs(EntityBlock::RELATION_ELEMENT);
            $blueprint
                ->foreignId(EntityBlock::BLOCK_ID)
                ->nullable()
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $blueprint
                ->integer(EntityBlock::POSITION)
                ->default(0);
        });

        Schema::table(EntityField::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->foreign(EntityField::ENTITY_BLOCK_UUID)
                ->references(EntityBlock::UUID)
                ->on(EntityBlock::TABLE)
                ->cascadeOnDelete();
        });
    }

    /**
     * Create the entity field entity table.
     *
     * @return void
     */
    private function createEntityFieldEntityTable(): void
    {
        Schema::create(EntityFieldEntity::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntityFieldEntity::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntityFieldEntity::ENTITY_FIELD_UUID)
                ->constrained(EntityField::TABLE, EntityField::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignUuid(EntityFieldEntity::ENTITY_UUID)
                ->constrained(Entity::TABLE, Entity::UUID)
                ->cascadeOnDelete();
        });
    }

    /**
     * Create the entity form table.
     *
     * @return void
     */
    private function createEntityFieldFormTable(): void
    {
        Schema::create(EntityFieldForm::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntityFieldForm::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntityFieldForm::ENTITY_FIELD_UUID)
                ->constrained(EntityField::TABLE, EntityField::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(EntityFieldForm::FORM_ID)
                ->constrained(Form::TABLE, Form::ID)
                ->cascadeOnDelete();
        });
    }

    /**
     * Create the entity field site page table.
     *
     * @return void
     */
    private function createEntityFieldSitePageTable(): void
    {
        Schema::create(EntityFieldSitePage::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntityFieldSitePage::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntityFieldSitePage::ENTITY_FIELD_UUID)
                ->constrained(EntityField::TABLE, EntityField::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(EntityFieldSitePage::SITE_PAGE_ID)
                ->constrained(SitePage::TABLE, SitePage::ID)
                ->cascadeOnDelete();
        });
    }

    #endregion
};
