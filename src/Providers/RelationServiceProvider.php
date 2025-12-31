<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\Input;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateTabElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RelationServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->bootMorphMap();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the morph map.
     *
     * @return void
     */
    protected function bootMorphMap(): void
    {
        Relation::enforceMorphMap([
            Block::TABLE => Block::class,
            BlockElement::TABLE => BlockElement::class,
            Field::TABLE => Field::class,
            Fieldset::TABLE => Fieldset::class,
            Input::TABLE => Input::class,
            TemplateTabElement::TABLE => TemplateTabElement::class,
        ]);
    }

    #endregion
}
