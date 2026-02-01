import { Icon } from "@narsil-cms/blocks/icon";
import { Button } from "@narsil-cms/components/button";
import { Tooltip } from "@narsil-cms/components/tooltip";
import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorUndoProps = ComponentProps<typeof Button> & {
  editor: Editor;
  label?: string;
};

function RichTextEditorUndo({ editor, label = "Undo", ...props }: RichTextEditorUndoProps) {
  const { canUndo } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canUndo: ctx.editor.can().chain().focus().undo().run(),
      };
    },
  });

  return (
    <Tooltip tooltip={label}>
      <Button
        aria-label={label}
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
