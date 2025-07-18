import { Editor } from "@tiptap/react";
import { ListOrderedIcon } from "lucide-react";
import { Toggle } from "@/components/ui/toggle";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";

type RichTextEditorOrderedListProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorOrderedList({
  editor,
  ...props
}: RichTextEditorOrderedListProps) {
  const { getLabel } = useLabels();

  return (
    <Tooltip tooltip={getLabel(`accessibility.toggle_ordered_list`)}>
      <Toggle
        aria-label={getLabel(
          `accessibility.toggle_ordered_list`,
          `Toggle ordered list`,
        )}
        pressed={editor.isActive("orderedList")}
        onClick={() => editor.chain().focus().toggleOrderedList().run()}
        {...props}
      >
        <ListOrderedIcon className="size-4" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorOrderedList;
