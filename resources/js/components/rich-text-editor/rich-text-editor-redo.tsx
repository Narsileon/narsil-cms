import { Editor, useEditorState } from "@tiptap/react";

import { Button, Tooltip } from "@narsil-cms/blocks";
import { useLabels } from "@narsil-cms/components/labels";

type RichTextEditorRedoProps = React.ComponentProps<typeof Button> & {
  editor: Editor;
};

function RichTextEditorRedo({ editor, ...props }: RichTextEditorRedoProps) {
  const { trans } = useLabels();

  const { canRedo } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canRedo: ctx.editor.can().chain().focus().redo().run(),
      };
    },
  });

  return (
    <Tooltip tooltip={trans(`accessibility.redo`)}>
      <Button
        aria-label={trans(`accessibility.redo`)}
        disabled={!canRedo}
        icon="redo"
        size="icon"
        variant="ghost"
        onClick={() => editor.chain().focus().redo().run()}
        {...props}
      />
    </Tooltip>
  );
}

export default RichTextEditorRedo;
