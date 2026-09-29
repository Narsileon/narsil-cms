<?php

declare(strict_types=1);

namespace Narsil\Cms\View\Components\Blocks\Status;

#region USE

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

#endregion

final class StatusCell extends Component
{
    #region CONSTRUCTOR

    /**
     * @param mixed $value
     *
     * @return void
     */
    public function __construct(mixed $value = [])
    {
        $this->draft = (bool) data_get($value, 'draft');
        $this->published = (bool) data_get($value, 'published');
        $this->saved = (bool) data_get($value, 'saved');
    }

    #endregion

    #region PROPERTIES

    /**
     * @var boolean
     */
    public readonly bool $draft;

    /**
     * @var boolean
     */
    public readonly bool $published;

    /**
     * @var boolean
     */
    public readonly bool $saved;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return View
     */
    public function render(): View
    {
        return view('narsil-cms::components.blocks.status.status-cell');
    }

    #endregion
}
