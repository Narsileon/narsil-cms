<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\FooterSitePage;
use Narsil\Models\Globals\FooterSocialLink;
use Narsil\Models\Sites\SitePage;
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
        if (!Schema::hasTable(Footer::TABLE))
        {
            $this->createFootersTable();
        }
        if (!Schema::hasTable(FooterSitePage::TABLE))
        {
            $this->createFooterSitePageTable();
        }
        if (!Schema::hasTable(FooterSocialLink::TABLE))
        {
            $this->createFooterSocialLinksTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(FooterSocialLink::TABLE);
        Schema::dropIfExists(FooterSitePage::TABLE);
        Schema::dropIfExists(Footer::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the footer site page table.
     *
     * @return void
     */
    private function createFooterSitePageTable(): void
    {
        Schema::create(FooterSitePage::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FooterSitePage::UUID)
                ->primary();
            $blueprint
                ->foreignId(FooterSitePage::FOOTER_ID)
                ->constrained(Footer::TABLE, Footer::ID)
                ->cascadeOnDelete();
            $blueprint
                ->bigInteger(FooterSitePage::SITE_PAGE_ID)
                ->constrained(SitePage::TABLE, SitePage::ID)
                ->cascadeOnDelete();
            $blueprint
                ->jsonb(FooterSitePage::LABEL)
                ->nullable();
            $blueprint
                ->integer(FooterSitePage::POSITION)
                ->default(0);
        });
    }

    /**
     * Create the footer social links table.
     *
     * @return void
     */
    private function createFooterSocialLinksTable(): void
    {
        Schema::create(FooterSocialLink::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FooterSocialLink::UUID)
                ->primary();
            $blueprint
                ->foreignId(FooterSocialLink::FOOTER_ID)
                ->constrained(Footer::TABLE, Footer::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(FooterSocialLink::ICON)
                ->nullable();
            $blueprint
                ->jsonb(FooterSocialLink::LABEL)
                ->nullable();
            $blueprint
                ->string(FooterSocialLink::URL)
                ->nullable();
            $blueprint
                ->integer(FooterSocialLink::POSITION)
                ->default(0);
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the footers table.
     *
     * @return void
     */
    private function createFootersTable(): void
    {
        Schema::create(Footer::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Footer::ID);
            $blueprint
                ->string(Footer::HANDLE)
                ->unique();
            $blueprint
                ->string(Footer::LOGO)
                ->nullable();
            $blueprint
                ->string(Footer::COMPANY)
                ->nullable();
            $blueprint
                ->string(Footer::ADDRESS_LINE_1)
                ->nullable();
            $blueprint
                ->string(Footer::ADDRESS_LINE_2)
                ->nullable();
            $blueprint
                ->jsonb(Footer::EMAIL)
                ->nullable();
            $blueprint
                ->string(Footer::PHONE)
                ->nullable();
            $blueprint
                ->timestamp(Footer::CREATED_AT);
            $blueprint
                ->foreignId(Footer::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamp(Footer::UPDATED_AT);
            $blueprint
                ->foreignId(Footer::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
        });
    }

    #endregion
};
