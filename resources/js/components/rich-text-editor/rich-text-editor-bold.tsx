import { Editor, useEditorState } from "@tiptap/react";

import { Tooltip } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import { ToggleRoot } from "@narsil-cms/components/toggle";

type RichTextEditorBoldProps = React.ComponentProps<typeof ToggleRoot> & {
  editor: Editor;
};

function RichTextEditorBold({ editor, ...props }: RichTextEditorBoldProps) {
  const { trans } = useLabels();

  const { canBold, isBold } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canBold: ctx.editor.can().chain().focus().toggleBold().run(),
        isBold: ctx.editor.isActive("bold"),
      };
    },
  });

  return (
    <Tooltip tooltip={trans(`accessibility.toggle_bold`)}>
      <ToggleRoot
        aria-label={trans(`accessibility.toggle_bold`, `Toggle bold`)}
        disabled={!canBold}
        pressed={isBold}
        size="icon"
        onClick={() => editor.chain().focus().toggleBold().run()}
        {...props}
      >
        <Icon name="bold" />
      </ToggleRoot>
    </Tooltip>
  );
}

export default RichTextEditorBold;
