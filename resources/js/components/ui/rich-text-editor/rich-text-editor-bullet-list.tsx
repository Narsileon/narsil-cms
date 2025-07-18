import { Editor } from "@tiptap/react";
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

  return (
    <Tooltip tooltip={getLabel(`accessibility.toggle_bullet_list`)}>
      <Toggle
        aria-label={getLabel(
          `accessibility.toggle_bullet_list`,
          `Toggle bullet list`,
        )}
        pressed={editor.isActive("bulletList")}
        onClick={() => editor.chain().focus().toggleBulletList().run()}
        {...props}
      >
        <ListIcon className="size-4" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorBulletList;
