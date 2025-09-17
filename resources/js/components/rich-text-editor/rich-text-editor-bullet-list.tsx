import { Editor, useEditorState } from "@tiptap/react";

import { Toggle, Tooltip } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import { type IconName } from "@narsil-cms/plugins/icons";

type RichTextEditorBulletListProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
  icon?: IconName;
};

function RichTextEditorBulletList({
  editor,
  icon = "list-bullet",
  ...props
}: RichTextEditorBulletListProps) {
  const { trans } = useLabels();

  const { isBulletList } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        isBulletList: ctx.editor.isActive("bulletList"),
      };
    },
  });

  return (
    <Tooltip tooltip={trans(`accessibility.toggle_bullet_list`)}>
      <Toggle
        aria-label={trans(
          `accessibility.toggle_bullet_list`,
          `Toggle bullet list`,
        )}
        pressed={isBulletList}
        size="icon"
        onClick={() => editor.chain().focus().toggleBulletList().run()}
        {...props}
      >
        <Icon name={icon} />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorBulletList;
