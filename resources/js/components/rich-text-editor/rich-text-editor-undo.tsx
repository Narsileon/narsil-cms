import * as React from "react";
import { Button } from "@narsil-cms/components/button";
import { Editor, useEditorState } from "@tiptap/react";
import { Icon } from "@narsil-cms/components/icon";
import { Tooltip } from "@narsil-cms/blocks";
import { useLabels } from "@narsil-cms/components/labels";

type RichTextEditorUndoProps = React.ComponentProps<typeof Button> & {
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

  return (
    <Tooltip tooltip={trans(`accessibility.undo`)}>
      <Button
        aria-label={trans(`accessibility.undo`)}
        disabled={!canUndo}
        size="icon"
        variant="ghost"
        onClick={() => editor.chain().focus().undo().run()}
        {...props}
      >
        <Icon name="undo" />
      </Button>
    </Tooltip>
  );
}

export default RichTextEditorUndo;
