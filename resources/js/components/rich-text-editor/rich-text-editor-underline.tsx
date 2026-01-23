import { Icon } from "@narsil-cms/blocks/icon";
import { Toggle } from "@narsil-cms/blocks/toggle";
import { useLocalization } from "@narsil-cms/components/localization";
import { type IconName } from "@narsil-cms/repositories/icons";
import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorUnderlineProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  icon?: IconName;
};

function RichTextEditorUnderline({
  editor,
  icon = "underline",
  ...props
}: RichTextEditorUnderlineProps) {
  const { trans } = useLocalization();

  const { canUnderline, isUnderline } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canUnderline: ctx.editor.can().chain().focus().toggleUnderline().run(),
        isUnderline: ctx.editor.isActive("underline"),
      };
    },
  });

  const tooltip = trans("rich-text-editor.underline");

  return (
    <Toggle
      disabled={!canUnderline}
      pressed={isUnderline}
      size="icon"
      tooltip={tooltip}
      onClick={() => editor.chain().focus().toggleUnderline().run()}
      {...props}
    >
      <Icon name={icon} />
    </Toggle>
  );
}

export default RichTextEditorUnderline;
