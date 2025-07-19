import { Editor, useEditorState } from "@tiptap/react";
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

  const { isOrderedList } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        isOrderedList: ctx.editor.isActive("orderedList"),
      };
    },
  });

  return (
    <Tooltip
      tooltip={getLabel(`accessibility.toggle_ordered_list`)}
      asChild={false}
    >
      <Toggle
        aria-label={getLabel(
          `accessibility.toggle_ordered_list`,
          `Toggle ordered list`,
        )}
        pressed={isOrderedList}
        size="icon"
        onClick={() => editor.chain().focus().toggleOrderedList().run()}
        {...props}
      >
        <ListOrderedIcon className="size-5" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorOrderedList;
