<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityBlock;
use Narsil\Models\Entities\EntityBlockField;
use Narsil\Models\Entities\EntityEntity;
use Narsil\Models\Entities\EntityForm;
use Narsil\Models\Entities\EntitySitePage;
use Narsil\Models\Forms\Form;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\Field;
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
        if (!Schema::hasTable(EntityBlock::TABLE))
        {
            $this->createEntityBlocksTable();
        }
        if (!Schema::hasTable(EntityBlockField::TABLE))
        {
            $this->createEntityBlockFieldsTable();
        }
        if (!Schema::hasTable(EntityEntity::TABLE))
        {
            $this->createEntityEntityTable();
        }
        if (!Schema::hasTable(EntityForm::TABLE))
        {
            $this->createEntityFormTable();
        }
        if (!Schema::hasTable(EntitySitePage::TABLE))
        {
            $this->createEntitySitePageTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(EntitySitePage::TABLE);
        Schema::dropIfExists(EntityForm::TABLE);
        Schema::dropIfExists(EntityEntity::TABLE);
        Schema::dropIfExists(EntityBlockField::TABLE);
        Schema::dropIfExists(EntityBlock::TABLE);
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
     * Create the entity block fields table.
     *
     * @return void
     */
    protected function createEntityBlockFieldsTable(): void
    {
        Schema::create(EntityBlockField::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntityBlockField::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntityBlockField::ENTITY_BLOCK_UUID)
                ->constrained(EntityBlock::TABLE, EntityBlock::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(EntityBlockField::FIELD_ID)
                ->constrained(Field::TABLE, Field::ID)
                ->cascadeOnDelete();
            $blueprint
                ->jsonb(EntityBlockField::VALUE)
                ->nullable();
        });

        Schema::table(EntityBlock::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->foreign(EntityBlock::ENTITY_BLOCK_FIELD_UUID)
                ->references(EntityBlockField::UUID)
                ->on(EntityBlockField::TABLE)
                ->nullOnDelete();
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
                ->uuid(EntityBlock::ENTITY_BLOCK_FIELD_UUID)
                ->nullable();
            $blueprint
                ->foreignId(EntityBlock::BLOCK_ID)
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $blueprint
                ->integer(EntityBlock::POSITION)
                ->default(0);
        });
    }

    /**
     * Create the entity entity table.
     *
     * @return void
     */
    private function createEntityEntityTable(): void
    {
        Schema::create(EntityEntity::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntityEntity::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntityEntity::OWNER_UUID)
                ->constrained(Entity::TABLE, Entity::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignUuid(EntityEntity::TARGET_UUID)
                ->constrained(Entity::TABLE, Entity::UUID)
                ->cascadeOnDelete();
        });
    }

    /**
     * Create the entity form table.
     *
     * @return void
     */
    private function createEntityFormTable(): void
    {
        Schema::create(EntityForm::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntityForm::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntityForm::ENTITY_UUID)
                ->constrained(Entity::TABLE, Entity::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(EntityForm::FORM_ID)
                ->constrained(Form::TABLE, Form::ID)
                ->cascadeOnDelete();
        });
    }

    /**
     * Create the entity site page table.
     *
     * @return void
     */
    private function createEntitySitePageTable(): void
    {
        Schema::create(EntitySitePage::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntitySitePage::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntitySitePage::ENTITY_UUID)
                ->constrained(Entity::TABLE, Entity::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(EntitySitePage::SITE_PAGE_ID)
                ->constrained(SitePage::TABLE, SitePage::ID)
                ->cascadeOnDelete();
        });
    }

    #endregion
};
