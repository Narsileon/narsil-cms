import { Editor, useEditorState } from "@tiptap/react";

import { Toggle, Tooltip } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";

type RichTextEditorUnderlineProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorUnderline({
  editor,
  ...props
}: RichTextEditorUnderlineProps) {
  const { trans } = useLabels();

  const { canUnderline, isUnderline } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canUnderline: ctx.editor.can().chain().focus().toggleUnderline().run(),
        isUnderline: ctx.editor.isActive("underline"),
      };
    },
  });

  return (
    <Tooltip tooltip={trans(`accessibility.toggle_underline`)}>
      <Toggle
        aria-label={trans(`accessibility.toggle_underline`, `Toggle underline`)}
        disabled={!canUnderline}
        pressed={isUnderline}
        size="icon"
        onClick={() => editor.chain().focus().toggleUnderline().run()}
        {...props}
      >
        <Icon name="underline" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorUnderline;
