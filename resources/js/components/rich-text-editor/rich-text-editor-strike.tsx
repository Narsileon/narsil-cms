import { Toggle } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { type IconName } from "@narsil-cms/plugins/icons";
import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorStrikeProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  icon?: IconName;
};

function RichTextEditorStrike({
  editor,
  icon = "strikethrough",
  ...props
}: RichTextEditorStrikeProps) {
  const { trans } = useLocalization();

  const { canStrike, isStrike } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canStrike: ctx.editor.can().chain().focus().toggleStrike().run(),
        isStrike: ctx.editor.isActive("strike"),
      };
    },
  });

  const tooltip = trans("rich-text-editor.strike");

  return (
    <Toggle
      disabled={!canStrike}
      pressed={isStrike}
      size="icon"
      tooltip={tooltip}
      onClick={() => editor.chain().focus().toggleStrike().run()}
      {...props}
    >
      <Icon name={icon} />
    </Toggle>
  );
}

export default RichTextEditorStrike;
