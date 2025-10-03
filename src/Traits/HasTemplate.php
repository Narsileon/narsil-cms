<?php

namespace Narsil\Traits;

use Narsil\Models\Elements\Template;

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
trait HasTemplate
{
    #region PROPERTIES

    /**
     * The template associated with the model.
     *
     * @var ?Template
     */
    protected static ?Template $template = null;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return string
     */
    abstract public static function getTableName(): string;

    /**
     * @return Template
     */
    public static function getTemplate(): Template
    {
        return static::$template;
    }

    /**
     * @param Template|string $template
     *
     * @return void
     */
    public static function setTemplate(Template|string $template): void
    {
        if (is_string($template))
        {
            $template = Template::query()
                ->firstWhere([
                    Template::HANDLE,
                    $template
                ]);
        }

        static::$template = $template;
    }

    #endregion
}
