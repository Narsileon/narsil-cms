import { Editor, useEditorState } from "@tiptap/react";

import { Toggle, Tooltip } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import { type IconName } from "@narsil-cms/plugins/icons";

type RichTextEditorItalicProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
  icon?: IconName;
};

function RichTextEditorItalic({
  editor,
  icon = "italic",
  ...props
}: RichTextEditorItalicProps) {
  const { trans } = useLabels();

  const { canItalic, isItalic } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canItalic: ctx.editor.can().chain().focus().toggleItalic().run(),
        isItalic: ctx.editor.isActive("italic"),
      };
    },
  });

  return (
    <Tooltip tooltip={trans(`accessibility.toggle_italic`)}>
      <Toggle
        aria-label={trans(`accessibility.toggle_italic`, `Toggle italic`)}
        disabled={!canItalic}
        pressed={isItalic}
        size="icon"
        onClick={() => editor.chain().focus().toggleItalic().run()}
        {...props}
      >
        <Icon name={icon} />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorItalic;
