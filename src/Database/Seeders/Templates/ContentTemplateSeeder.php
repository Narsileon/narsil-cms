<?php

namespace Narsil\Cms\Database\Seeders\Templates;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Cms\Database\Seeders\Blocks\AccordionBlockSeeder;
use Narsil\Cms\Database\Seeders\Blocks\CallToActionBlockSeeder;
use Narsil\Cms\Database\Seeders\Blocks\HeroHeaderBlockSeeder;
use Narsil\Cms\Http\Data\Forms\Inputs\BuilderInputData;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class ContentTemplateSeeder extends Seeder
{
    #region CONSTANTS

    /**
     * The name of the "content" field.
     *
     * @var string
     */
    public const CONTENT = 'content';

    #endregion


    #region PUBLIC METHODS

    /**
     * @return Template
     */
    public function run(): Template
    {
        if ($field = Template::firstWhere(Template::TABLE_NAME, 'contents'))
        {
            return $field;
        }

        $AccordionBlockSeeder = new AccordionBlockSeeder()->run();
        $CallToActionBlockSeeder = new CallToActionBlockSeeder()->run();
        $HeroHeaderBlockSeeder = new HeroHeaderBlockSeeder()->run();

        return Template::factory()
            ->has(
                TemplateTab::factory()->state([
                    TemplateTab::HANDLE => 'content',
                    TemplateTab::LABEL => 'content',
                ])->hasAttached(
                    Field::factory()->state([
                        Field::HANDLE => 'content_builder',
                        Field::LABEL => 'Content Builder',
                        Field::TYPE => BuilderInputData::TYPE,
                    ])->hasAttached(
                        $AccordionBlockSeeder,
                        [],
                        Field::RELATION_BLOCKS
                    )->hasAttached(
                        $CallToActionBlockSeeder,
                        [],
                        Field::RELATION_BLOCKS
                    )->hasAttached(
                        $HeroHeaderBlockSeeder,
                        [],
                        Field::RELATION_BLOCKS
                    ),
                    [
                        TemplateTabElement::HANDLE => self::CONTENT,
                        TemplateTabElement::LABEL  => 'Content',
                        TemplateTabElement::POSITION => 1,
                    ],
                    TemplateTab::RELATION_FIELDS
                ),
                Template::RELATION_TABS
            )
            ->create([
                Template::PLURAL => 'Contents',
                Template::SINGULAR => 'Content',
                Template::TABLE_NAME => 'contents',
            ]);
    }

    #endregion
}
