<?php

#region USE

use Narsil\Enums\Forms\RichTextEditorEnum;

#endregion

return [
    'modules' => [
        RichTextEditorEnum::ALIGN_CENTER->value => 'Align Center',
        RichTextEditorEnum::ALIGN_JUSTIFY->value => 'Align Justify',
        RichTextEditorEnum::ALIGN_LEFT->value => 'Align Left',
        RichTextEditorEnum::ALIGN_RIGHT->value => 'Align Right',
        RichTextEditorEnum::BOLD->value => 'Bold',
        RichTextEditorEnum::BULLET_LIST->value => 'Bullet List',
        RichTextEditorEnum::HEADING_1->value => 'Heading 1',
        RichTextEditorEnum::HEADING_2->value => 'Heading 2',
        RichTextEditorEnum::HEADING_3->value => 'Heading 3',
        RichTextEditorEnum::HEADING_4->value => 'Heading 4',
        RichTextEditorEnum::HEADING_5->value => 'Heading 5',
        RichTextEditorEnum::HEADING_6->value => 'Heading 6',
        RichTextEditorEnum::ITALIC->value => 'Italic',
        RichTextEditorEnum::LINK->value => 'Link',
        RichTextEditorEnum::ORDERED_LIST->value => 'Ordered List',
        RichTextEditorEnum::PARAGRAPH->value => 'Paragraph',
        RichTextEditorEnum::REDO->value => 'Redo',
        RichTextEditorEnum::STRIKE->value => 'Strike',
        RichTextEditorEnum::SUBSCRIPT->value => 'Subscript',
        RichTextEditorEnum::SUPERSCRIPT->value => 'Superscript',
        RichTextEditorEnum::UNDERLINE->value => 'Underline',
        RichTextEditorEnum::UNDO->value => 'Undo',
    ],
    'toggles' => [
        'align_center'  => 'Toggle align center',
        'align_justify' => 'Toggle align justify',
        'align_left'    => 'Toggle align left',
        'align_right'   => 'Toggle align right',
        'bold'          => 'Toggle bold',
        'bullet_list'   => 'Toggle bullet list',
        'heading_1'     => 'Toggle heading 1',
        'heading_2'     => 'Toggle heading 2',
        'heading_3'     => 'Toggle heading 3',
        'heading_4'     => 'Toggle heading 4',
        'heading_5'     => 'Toggle heading 5',
        'heading_6'     => 'Toggle heading 6',
        'heading_menu'  => 'Toggle heading menu',
        'italic'        => 'Toggle italic',
        'ordered_list'  => 'Toggle ordered list',
        'strike'        => 'Toggle strike',
        'subscript'     => 'Toggle subscript',
        'superscript'   => 'Toggle superscript',
        'underline'     => 'Toggle underline',
    ],
];
