<?php

namespace Narsil\Cms\Database\Seeders\Templates;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Cms\Database\Seeders\Blocks\AccordionBlockSeeder;
use Narsil\Cms\Database\Seeders\Blocks\CallToActionBlockSeeder;
use Narsil\Cms\Database\Seeders\Blocks\HeroHeaderBlockSeeder;
use Narsil\Cms\Http\Data\Forms\Inputs\BuilderInputData;
use Narsil\Cms\Models\Collections\Block;
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
    #region CONSTRUCTOR

    /**
     * @param Block[] $blocks
     *
     * @return void
     */
    public function __construct(array $blocks = [])
    {
        $accordionBlockSeeder = new AccordionBlockSeeder()->run();
        $callToActionBlockSeeder = new CallToActionBlockSeeder()->run();
        $heroHeaderBlockSeeder = new HeroHeaderBlockSeeder()->run();

        $this->blocks = array_merge($blocks, [
            $accordionBlockSeeder,
            $callToActionBlockSeeder,
            $heroHeaderBlockSeeder,
        ]);
    }

    #endregion

    #region CONSTANTS

    /**
     * The name of the "content" field.
     *
     * @var string
     */
    public const CONTENT = 'content';

    #endregion

    #region PROPERTIES

    /**
     * @var Block[]
     */
    private readonly array $blocks;

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

        $fieldFactory = Field::factory()->state([
            Field::HANDLE => 'content_builder',
            Field::LABEL => 'Content Builder',
            Field::TYPE => BuilderInputData::TYPE,
        ]);

        foreach ($this->blocks as $block)
        {
            $fieldFactory = $fieldFactory->hasAttached(
                $block,
                [],
                Field::RELATION_BLOCKS
            );
        }

        return Template::factory()
            ->has(
                TemplateTab::factory()->state([
                    TemplateTab::HANDLE => 'content',
                    TemplateTab::LABEL => 'content',
                ])->hasAttached(
                    $fieldFactory,
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
