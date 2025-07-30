<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Elements\Field;

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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(Field::TABLE);
    }

    #endregion

    #region PRIVATE METHODS



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
