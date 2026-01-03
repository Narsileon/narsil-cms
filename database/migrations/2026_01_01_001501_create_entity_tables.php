<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityNode;
use Narsil\Models\Entities\EntityNodeEntity;
use Narsil\Models\Entities\EntityNodeForm;
use Narsil\Models\Entities\EntityNodeSitePage;
use Narsil\Models\Forms\Form;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Template;
use Narsil\Models\Structures\TemplateTabElement;
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
        if (!Schema::hasTable(EntityNode::TABLE))
        {
            $this->createEntityNodesTable();
        }
        if (!Schema::hasTable(EntityNodeEntity::TABLE))
        {
            $this->createEntityNodeEntityTable();
        }
        if (!Schema::hasTable(EntityNodeForm::TABLE))
        {
            $this->createEntityNodeFormTable();
        }
        if (!Schema::hasTable(EntityNodeSitePage::TABLE))
        {
            $this->createEntityNodeSitePageTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(EntityNodeSitePage::TABLE);
        Schema::dropIfExists(EntityNodeForm::TABLE);
        Schema::dropIfExists(EntityNodeEntity::TABLE);
        Schema::dropIfExists(EntityNode::TABLE);
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
     * Create the entity field entity table.
     *
     * @return void
     */
    private function createEntityNodeEntityTable(): void
    {
        Schema::create(EntityNodeEntity::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntityNodeEntity::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntityNodeEntity::ENTITY_NODE_UUID)
                ->constrained(EntityNode::TABLE, EntityNode::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignUuid(EntityNodeEntity::OWNER_UUID)
                ->constrained(Entity::TABLE, Entity::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignUuid(EntityNodeEntity::TARGET_UUID)
                ->constrained(Entity::TABLE, Entity::UUID)
                ->cascadeOnDelete();
        });
    }

    /**
     * Create the entity form table.
     *
     * @return void
     */
    private function createEntityNodeFormTable(): void
    {
        Schema::create(EntityNodeForm::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntityNodeForm::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntityNodeForm::ENTITY_UUID)
                ->constrained(Entity::TABLE, Entity::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignUuid(EntityNodeForm::ENTITY_NODE_UUID)
                ->constrained(EntityNode::TABLE, EntityNode::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(EntityNodeForm::FORM_ID)
                ->constrained(Form::TABLE, Form::ID)
                ->cascadeOnDelete();
        });
    }

    /**
     * Create the entity field site page table.
     *
     * @return void
     */
    private function createEntityNodeSitePageTable(): void
    {
        Schema::create(EntityNodeSitePage::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntityNodeSitePage::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntityNodeSitePage::ENTITY_UUID)
                ->constrained(Entity::TABLE, Entity::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignUuid(EntityNodeSitePage::ENTITY_NODE_UUID)
                ->constrained(EntityNode::TABLE, EntityNode::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(EntityNodeSitePage::SITE_PAGE_ID)
                ->constrained(SitePage::TABLE, SitePage::ID)
                ->cascadeOnDelete();
        });
    }

    /**
     * Create the entity blocks table.
     *
     * @return void
     */
    protected function createEntityNodesTable(): void
    {
        Schema::create(EntityNode::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntityNode::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntityNode::ENTITY_UUID)
                ->constrained(Entity::TABLE, Entity::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->uuid(EntityNode::PARENT_UUID)
                ->nullable();
            $blueprint
                ->nullableUuidMorphs(EntityNode::RELATION_ELEMENT);
            $blueprint
                ->foreignUuid(EntityNode::BLOCK_ELEMENT_UUID)
                ->nullable()
                ->constrained(BlockElement::TABLE, BlockElement::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignUuid(EntityNode::TEMPLATE_TAB_ELEMENT_UUID)
                ->nullable()
                ->foreignUuid(TemplateTabElement::TABLE, TemplateTabElement::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(EntityNode::BLOCK_ID)
                ->nullable()
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $blueprint
                ->integer(EntityNode::POSITION)
                ->default(0);
            $blueprint
                ->string(EntityNode::PATH)
                ->nullable();
            $blueprint
                ->jsonb(EntityNode::VALUE)
                ->nullable();
        });

        Schema::table(EntityNode::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->foreign(EntityNode::PARENT_UUID)
                ->references(EntityNode::UUID)
                ->on(EntityNode::TABLE)
                ->cascadeOnDelete();
        });
    }

    #endregion
};
