import { Button } from "@narsil-cms/blocks";
import { useLocalization } from "@narsil-cms/components/localization";
import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorRedoProps = ComponentProps<typeof Button> & {
  editor: Editor;
};

function RichTextEditorRedo({ editor, ...props }: RichTextEditorRedoProps) {
  const { trans } = useLocalization();

  const { canRedo } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canRedo: ctx.editor.can().chain().focus().redo().run(),
      };
    },
  });

  const tooltip = trans("rich-text-editor.redo");

  return (
    <Button
      disabled={!canRedo}
      icon="redo"
      size="icon"
      tooltip={tooltip}
      variant="ghost"
      onClick={() => editor.chain().focus().redo().run()}
      {...props}
    />
  );
}

export default RichTextEditorRedo;
