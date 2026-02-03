import { Icon } from "@narsil-cms/components/icon";
import { Toggle } from "@narsil-cms/components/toggle";
import { Tooltip } from "@narsil-cms/components/tooltip";
import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorBulletListProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  label?: string;
};

function RichTextEditorBulletList({
  editor,
  label = "Bullet list",
  ...props
}: RichTextEditorBulletListProps) {
  const { isBulletList } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        isBulletList: ctx.editor.isActive("bulletList"),
      };
    },
  });

  return (
    <Tooltip tooltip={label}>
      <Toggle
        aria-label={label}
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
