import * as React from "react";
import { Editor, useEditorState } from "@tiptap/react";
import { Icon } from "@narsil-cms/components/ui/icon";
import { ToggleRoot } from "@narsil-cms/components/ui/toggle";
import { Tooltip } from "@narsil-cms/blocks";
import { useLabels } from "@narsil-cms/components/ui/labels";

type RichTextEditorBulletListProps = React.ComponentProps<typeof ToggleRoot> & {
  editor: Editor;
};

function RichTextEditorBulletList({
  editor,
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
      <ToggleRoot
        aria-label={trans(
          `accessibility.toggle_bullet_list`,
          `Toggle bullet list`,
        )}
        pressed={isBulletList}
        size="icon"
        onClick={() => editor.chain().focus().toggleBulletList().run()}
        {...props}
      >
        <Icon name="list-bullet" />
      </ToggleRoot>
    </Tooltip>
  );
}

export default RichTextEditorBulletList;
