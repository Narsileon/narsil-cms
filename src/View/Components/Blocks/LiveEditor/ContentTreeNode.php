<?php

declare(strict_types=1);

namespace Narsil\Cms\View\Components\Blocks\LiveEditor;

#region USE

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

#endregion

final class ContentTreeNode extends Component
{
    #region CONSTRUCTOR

    /**
     * @param array<string,mixed> $node
     * @param string|null $selectedNodeId
     *
     * @return void
     */
    public function __construct(
        array $node,
        ?string $selectedNodeId,
    ) {
        $this->isBuilder = data_get($node, 'type') === 'builder';
        $this->isSelected = $selectedNodeId === data_get($node, 'id');
        $this->node = $node;
        $this->selectedNodeId = $selectedNodeId;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var boolean
     */
    public readonly bool $isBuilder;

    /**
     * @var boolean
     */
    public readonly bool $isSelected;

    /**
     * @var array<string,mixed>
     */
    public readonly array $node;

    /**
     * @var string|null
     */
    public readonly ?string $selectedNodeId;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return View
     */
    public function render(): View
    {
        return view('narsil-cms::components.blocks.live-editor.content-tree-node');
    }

    #endregion
}
