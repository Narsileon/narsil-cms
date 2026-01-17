<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\FooterLink;
use Narsil\Models\Globals\FooterSocialMedium;
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
        if (!Schema::hasTable(FooterLink::TABLE))
        {
            $this->createFooterLinkTable();
        }
        if (!Schema::hasTable(FooterSocialMedium::TABLE))
        {
            $this->createFooterSocialMediaTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(FooterSocialMedium::TABLE);
        Schema::dropIfExists(FooterLink::TABLE);
        Schema::dropIfExists(Footer::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the footer site page table.
     *
     * @return void
     */
    private function createFooterLinkTable(): void
    {
        Schema::create(FooterLink::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FooterLink::UUID)
                ->primary();
            $blueprint
                ->foreignId(FooterLink::FOOTER_ID)
                ->constrained(Footer::TABLE, Footer::ID)
                ->cascadeOnDelete();
            $blueprint
                ->bigInteger(FooterLink::SITE_PAGE_ID)
                ->constrained(SitePage::TABLE, SitePage::ID)
                ->cascadeOnDelete();
            $blueprint
                ->jsonb(FooterLink::LABEL)
                ->nullable();
            $blueprint
                ->integer(FooterLink::POSITION)
                ->default(0);
        });
    }

    /**
     * Create the footer social modia table.
     *
     * @return void
     */
    private function createFooterSocialMediaTable(): void
    {
        Schema::create(FooterSocialMedium::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FooterSocialMedium::UUID)
                ->primary();
            $blueprint
                ->foreignId(FooterSocialMedium::FOOTER_ID)
                ->constrained(Footer::TABLE, Footer::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(FooterSocialMedium::ICON)
                ->nullable();
            $blueprint
                ->jsonb(FooterSocialMedium::LABEL)
                ->nullable();
            $blueprint
                ->string(FooterSocialMedium::URL)
                ->nullable();
            $blueprint
                ->integer(FooterSocialMedium::POSITION)
                ->default(0);
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
                ->string(Footer::SLUG)
                ->unique();
            $blueprint
                ->string(Footer::LOGO)
                ->nullable();
            $blueprint
                ->string(Footer::COMPANY)
                ->nullable();
            $blueprint
                ->string(Footer::STREET)
                ->nullable();
            $blueprint
                ->string(Footer::POSTAL_CODE)
                ->nullable();
            $blueprint
                ->jsonb(Footer::CITY)
                ->nullable();
            $blueprint
                ->string(Footer::COUNTRY)
                ->nullable();
            $blueprint
                ->jsonb(Footer::EMAIL)
                ->nullable();
            $blueprint
                ->string(Footer::PHONE)
                ->nullable();
            $blueprint
                ->jsonb(Footer::COPYRIGHT)
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
