<?php

declare(strict_types=1);

namespace Narsil\Cms\View\Components\Blocks\LiveEditor;

#region USE

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

#endregion

final class PageTreeItem extends Component
{
    #region CONSTRUCTOR

    /**
     * @param integer $currentSitePageId
     * @param array<string,mixed> $page
     *
     * @return void
     */
    public function __construct(
        int $currentSitePageId,
        array $page,
    ) {
        $this->currentSitePageId = $currentSitePageId;
        $this->isCurrentPage = (int) data_get($page, 'id') === $currentSitePageId;
        $this->page = $page;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var integer
     */
    public readonly int $currentSitePageId;

    /**
     * @var boolean
     */
    public readonly bool $isCurrentPage;

    /**
     * @var array<string,mixed>
     */
    public readonly array $page;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return View
     */
    public function render(): View
    {
        return view('narsil-cms::components.blocks.live-editor.page-tree-item');
    }

    #endregion
}
