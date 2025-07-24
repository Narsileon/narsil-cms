<?php

namespace Narsil\Http\Components;

#region USE

use Narsil\Contracts\Components\Component;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractComponent implements Component
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->registerLabels();
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * @return array
     */
    public function get(): array
    {
        return [
            'content' => $this->content(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array
     */
    abstract protected function content(): array;

    /**
     * @return void
     */
    protected function registerLabels(): void
    {
        //
    }

    #endregion
}
