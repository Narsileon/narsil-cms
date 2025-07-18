import { Editor, useEditorState } from "@tiptap/react";
import { ListIcon } from "lucide-react";
import { Toggle } from "@/components/ui/toggle";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";

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
        onClick={() => editor.chain().focus().toggleBulletList().run()}
        {...props}
      >
        <ListIcon className="size-5" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorBulletList;
