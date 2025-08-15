<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityElement;

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
        if (!Schema::hasTable(EntityElement::TABLE))
        {
            $this->createEntityElementsTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(EntityElement::TABLE);
        Schema::dropIfExists(Entity::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createEntitiesTable(): void
    {
        Schema::create(Entity::TABLE, function (Blueprint $table)
        {
            $table
                ->id(Entity::ID);
            $table
                ->foreignId(Entity::TEMPLATE_ID)
                ->constrained(Template::TABLE, Template::ID)
                ->cascadeOnDelete();
            $table
                ->uuid(Entity::UUID)
                ->unique();
            $table
                ->timestamps();
            $table
                ->softDeletes();
        });
    }

    /**
     * @return void
     */
    private function createEntityElementsTable(): void
    {
        Schema::create(EntityElement::TABLE, function (Blueprint $table)
        {
            $table
                ->id(EntityElement::ID);
            $table
                ->foreignUuid(EntityElement::ENTITY_UUID)
                ->constrained(Entity::TABLE, Entity::UUID)
                ->cascadeOnDelete();
        });
    }

    #endregion
};
