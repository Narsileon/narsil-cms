<?php

namespace Narsil\Database\Seeders;

#region USE

use Narsil\Models\Structures\Block;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class BlockSeeder extends ElementSeeder
{
    #region PUBLIC METHODS

    /**
     * @return Block
     */
    public function run(): Block
    {
        $block = $this->block();

        return $this->saveBlock($block);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return Block
     */
    abstract protected function block(): Block;

    #endregion
}
