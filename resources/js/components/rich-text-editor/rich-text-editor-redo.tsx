import { Editor, useEditorState } from "@tiptap/react";

import { Tooltip } from "@narsil-cms/blocks";
import { ButtonRoot } from "@narsil-cms/components/button";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";

type RichTextEditorRedoProps = React.ComponentProps<typeof ButtonRoot> & {
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
      <ButtonRoot
        aria-label={trans(`accessibility.redo`)}
        disabled={!canRedo}
        size="icon"
        variant="ghost"
        onClick={() => editor.chain().focus().redo().run()}
        {...props}
      >
        <Icon name="redo" />
      </ButtonRoot>
    </Tooltip>
  );
}

export default RichTextEditorRedo;
