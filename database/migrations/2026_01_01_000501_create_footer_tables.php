<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Base\Models\User;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\FooterLink;
use Narsil\Cms\Models\Globals\FooterSocialMedium;
use Narsil\Cms\Models\Sites\SitePage;

#endregion

return new class extends Migration
{
    use HasSchemas;

    #region PUBLIC METHODS

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        foreach ($this->getSchemas() as $schema)
        {
            if (!Schema::hasTable("$schema." . Footer::TABLE))
            {
                $this->createFootersTable($schema);
            }
            if (!Schema::hasTable("$schema." . FooterLink::TABLE))
            {
                $this->createFooterLinkTable($schema);
            }
            if (!Schema::hasTable("$schema." . FooterSocialMedium::TABLE))
            {
                $this->createFooterSocialMediaTable($schema);
            }
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        foreach ($this->getSchemas() as $schema)
        {
            Schema::dropIfExists("$schema." . FooterSocialMedium::TABLE);
            Schema::dropIfExists("$schema." . FooterLink::TABLE);
            Schema::dropIfExists("$schema." . Footer::TABLE);
        };
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the footer site page table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createFooterLinkTable(string $schema): void
    {
        Schema::create("$schema." . FooterLink::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->uuid(FooterLink::UUID)
                ->primary();
            $blueprint
                ->foreignId(FooterLink::FOOTER_ID)
                ->constrained("$schema." . Footer::TABLE, Footer::ID)
                ->cascadeOnDelete();
            $blueprint
                ->bigInteger(FooterLink::SITE_PAGE_ID)
                ->constrained("$schema." . SitePage::TABLE, SitePage::ID)
                ->cascadeOnDelete();
            $blueprint
                ->jsonb(FooterLink::LABEL)
                ->nullable();
            $blueprint
                ->integer(FooterLink::POSITION)
                ->default(0)
                ->index();
        });
    }

    /**
     * Create the footer social modia table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createFooterSocialMediaTable(string $schema): void
    {
        Schema::create("$schema." . FooterSocialMedium::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->uuid(FooterSocialMedium::UUID)
                ->primary();
            $blueprint
                ->foreignId(FooterSocialMedium::FOOTER_ID)
                ->constrained("$schema." . Footer::TABLE, Footer::ID)
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
                ->default(0)
                ->index();
        });
    }

    /**
     * Create the footers table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createFootersTable(string $schema): void
    {
        Schema::create("$schema." . Footer::TABLE, function (Blueprint $blueprint)
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
                ->jsonb(Footer::COPYRIGHT)
                ->nullable();
            $blueprint
                ->string(Footer::ORGANIZATION)
                ->nullable();
            $blueprint
                ->jsonb(Footer::EMAIL)
                ->nullable();
            $blueprint
                ->string(Footer::PHONE)
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
                ->boolean(Footer::ORGANIZATION_SCHEMA)
                ->default(true);
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
