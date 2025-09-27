import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

import { Button } from "@narsil-cms/blocks";
import { useLabels } from "@narsil-cms/components/labels";

type RichTextEditorUndoProps = ComponentProps<typeof Button> & {
  editor: Editor;
};

function RichTextEditorUndo({ editor, ...props }: RichTextEditorUndoProps) {
  const { trans } = useLabels();

  const { canUndo } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canUndo: ctx.editor.can().chain().focus().undo().run(),
      };
    },
  });

  const tooltip = trans(`accessibility.undo`, `Undo`);

  return (
    <Button
      disabled={!canUndo}
      icon="undo"
      size="icon"
      tooltip={tooltip}
      variant="ghost"
      onClick={() => editor.chain().focus().undo().run()}
      {...props}
    />
  );
}

export default RichTextEditorUndo;
