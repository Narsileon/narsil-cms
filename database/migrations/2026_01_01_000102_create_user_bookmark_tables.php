<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Cms\Models\User;
use Narsil\Cms\Models\Users\UserBookmark;

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
        if (!Schema::hasTable(UserBookmark::TABLE))
        {
            $this->createUserBookmarksTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(UserBookmark::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the user bookmarks table.
     *
     * @return void
     */
    private function createUserBookmarksTable(): void
    {
        Schema::create(UserBookmark::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(UserBookmark::UUID)
                ->primary();
            $blueprint
                ->foreignId(UserBookmark::USER_ID)
                ->constrained(User::TABLE, User::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(UserBookmark::NAME);
            $blueprint
                ->string(UserBookmark::URL);
            $blueprint
                ->timestamps();
        });
    }

    #endregion
};
