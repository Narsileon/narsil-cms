import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

import { Toggle } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { type IconName } from "@narsil-cms/plugins/icons";

type RichTextEditorItalicProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  icon?: IconName;
};

function RichTextEditorItalic({
  editor,
  icon = "italic",
  ...props
}: RichTextEditorItalicProps) {
  const { trans } = useLocalization();

  const { canItalic, isItalic } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canItalic: ctx.editor.can().chain().focus().toggleItalic().run(),
        isItalic: ctx.editor.isActive("italic"),
      };
    },
  });

  const tooltip = trans("rich-text-editor.toggles.italic");

  return (
    <Toggle
      disabled={!canItalic}
      pressed={isItalic}
      size="icon"
      tooltip={tooltip}
      onClick={() => editor.chain().focus().toggleItalic().run()}
      {...props}
    >
      <Icon name={icon} />
    </Toggle>
  );
}

export default RichTextEditorItalic;
