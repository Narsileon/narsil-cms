import { Button } from "@narsil-cms/blocks/button";
import { useLocalization } from "@narsil-cms/components/localization";
import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorUndoProps = ComponentProps<typeof Button> & {
  editor: Editor;
};

function RichTextEditorUndo({ editor, ...props }: RichTextEditorUndoProps) {
  const { trans } = useLocalization();

  const { canUndo } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canUndo: ctx.editor.can().chain().focus().undo().run(),
      };
    },
  });

  const tooltip = trans("rich-text-editor.undo");

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
