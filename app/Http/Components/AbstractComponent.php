<?php

namespace App\Http\Components;

#region USE

use App\Interfaces\Components\IComponent;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractComponent implements IComponent
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
            'content' => $this->getContent(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array
     */
    abstract protected function getContent(): array;

    /**
     * @return void
     */
    protected function registerLabels(): void
    {
        //
    }

    #endregion
}
