import { Editor, useEditorState } from "@tiptap/react";

import { Toggle, Tooltip } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";

type RichTextEditorStrikeProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorStrike({ editor, ...props }: RichTextEditorStrikeProps) {
  const { trans } = useLabels();

  const { canStrike, isStrike } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canStrike: ctx.editor.can().chain().focus().toggleStrike().run(),
        isStrike: ctx.editor.isActive("strike"),
      };
    },
  });

  return (
    <Tooltip tooltip={trans(`accessibility.toggle_strike`)}>
      <Toggle
        aria-label={trans(`accessibility.toggle_strike`, `Toggle strike`)}
        disabled={!canStrike}
        pressed={isStrike}
        size="icon"
        onClick={() => editor.chain().focus().toggleStrike().run()}
        {...props}
      >
        <Icon name="strikethrough" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorStrike;
