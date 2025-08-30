<?php

namespace Narsil\Enums\Forms;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
enum RichTextEditorEnum: string
{
    use Enumerable;

    case ALIGN_CENTER = 'align_center';
    case ALIGN_JUSTIFY = 'align_justify';
    case ALIGN_LEFT = 'align_left';
    case ALIGN_RIGHT = 'align_right';
    case BOLD = 'bold';
    case BULLET_LIST = 'bullet_list';
    case HEADING_1 = 'heading_1';
    case HEADING_2 = 'heading_2';
    case HEADING_3 = 'heading_3';
    case HEADING_4 = 'heading_4';
    case HEADING_5 = 'heading_5';
    case HEADING_6 = 'heading_6';
    case ITALIC = 'italic';
    case LINK = 'link';
    case ORDERED_LIST = 'ordered_list';
    case PARAGRAPH = 'paragraph';
    case REDO = 'redo';
    case STRIKE = 'strike';
    case SUBSCRIPT = 'subscript';
    case SUPERSCRIPT = 'superscript';
    case UNDERLINE = 'underline';
    case UNDO = 'undo';
}
