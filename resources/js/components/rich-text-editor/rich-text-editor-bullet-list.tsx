import { Toggle } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { type IconName } from "@narsil-cms/plugins/icons";
import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorBulletListProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  icon?: IconName;
};

function RichTextEditorBulletList({
  editor,
  icon = "list-bullet",
  ...props
}: RichTextEditorBulletListProps) {
  const { trans } = useLocalization();

  const { isBulletList } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        isBulletList: ctx.editor.isActive("bulletList"),
      };
    },
  });

  const tooltip = trans("rich-text-editor.bullet_list");

  return (
    <Toggle
      pressed={isBulletList}
      size="icon"
      tooltip={tooltip}
      onClick={() => editor.chain().focus().toggleBulletList().run()}
      {...props}
    >
      <Icon name={icon} />
    </Toggle>
  );
}

export default RichTextEditorBulletList;
