<?php

namespace Narsil\Cms\Implementations\Actions\Templates;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\Elements\SyncElementConditions;
use Narsil\Cms\Contracts\Actions\Templates\SyncTemplateTabElements as Contract;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;

#endregion

/**
 * @author Jonathan Rigaux
 */
class SyncTemplateTabElements extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(TemplateTab $templateTab, array $elements): TemplateTab
    {
        $uuids = [];

        foreach ($elements as $position => $element)
        {
            $identifier = Arr::get($element, TemplateTabElement::ATTRIBUTE_IDENTIFIER);

            if (!$identifier || ! Str::contains($identifier, '-'))
            {
                continue;
            }

            [$table, $id] = explode('-', $identifier);

            $templateTabElement = TemplateTabElement::updateOrCreate([
                TemplateTabElement::OWNER_UUID => $templateTab->{TemplateTab::UUID},
                TemplateTabElement::HANDLE => Arr::get($element, TemplateTabElement::HANDLE),
                TemplateTabElement::BASE_TYPE => $table,
                TemplateTabElement::BASE_ID => $id,
            ], [
                TemplateTabElement::DESCRIPTION => Arr::get($element, TemplateTabElement::DESCRIPTION),
                TemplateTabElement::LABEL => Arr::get($element, TemplateTabElement::LABEL),
                TemplateTabElement::POSITION => $position,
                TemplateTabElement::REQUIRED => Arr::get($element, TemplateTabElement::REQUIRED, false),
                TemplateTabElement::TRANSLATABLE => Arr::get($element, TemplateTabElement::TRANSLATABLE, false),
                TemplateTabElement::WIDTH => Arr::get($element, TemplateTabElement::WIDTH, 100),
            ]);

            app(SyncElementConditions::class)
                ->run($templateTabElement, Arr::get($element, TemplateTabElement::RELATION_CONDITIONS, []));

            $uuids[] = $templateTabElement->{TemplateTabElement::UUID};
        }

        $templateTab
            ->elements()
            ->whereNotIn(TemplateTabElement::UUID, $uuids)
            ->delete();

        return $templateTab;
    }

    #endregion
}
