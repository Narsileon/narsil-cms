import { Button } from "@narsil-cms/blocks/button";
import { Icon } from "@narsil-cms/blocks/icon";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorRedoProps = ComponentProps<typeof Button> & {
  editor: Editor;
  label?: string;
};

function RichTextEditorRedo({ editor, label = "Redo", ...props }: RichTextEditorRedoProps) {
  const { canRedo } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canRedo: ctx.editor.can().chain().focus().redo().run(),
      };
    },
  });

  return (
    <Tooltip tooltip={label}>
      <Button
        aria-label={label}
        disabled={!canRedo}
        size="icon"
        variant="ghost"
        onClick={() => editor.chain().focus().redo().run()}
        {...props}
      >
        <Icon name="redo" />
      </Button>
    </Tooltip>
  );
}

export default RichTextEditorRedo;
