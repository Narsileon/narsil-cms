import * as React from "react";
import { Editor, useEditorState } from "@tiptap/react";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Toggle } from "@narsil-cms/components/ui/toggle";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";

type RichTextEditorBulletListProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorBulletList({
  editor,
  ...props
}: RichTextEditorBulletListProps) {
  const { getLabel } = useLabels();

  const { isBulletList } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        isBulletList: ctx.editor.isActive("bulletList"),
      };
    },
  });

  return (
    <Tooltip
      tooltip={getLabel(`accessibility.toggle_bullet_list`)}
      asChild={false}
    >
      <Toggle
        aria-label={getLabel(
          `accessibility.toggle_bullet_list`,
          `Toggle bullet list`,
        )}
        pressed={isBulletList}
        size="icon"
        onClick={() => editor.chain().focus().toggleBulletList().run()}
        {...props}
      >
        <Icon name="list-bullet" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorBulletList;
