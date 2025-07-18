import { Editor } from "@tiptap/react";
import { Toggle } from "@/components/ui/toggle";
import { Tooltip } from "@/components/ui/tooltip";
import { UnderlineIcon } from "lucide-react";
import { useLabels } from "@/components/ui/labels";

type RichTextEditorUnderlineProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorUnderline({
  editor,
  ...props
}: RichTextEditorUnderlineProps) {
  const { getLabel } = useLabels();

  return (
    <Tooltip tooltip={getLabel(`accessibility.toggle_underline`)}>
      <Toggle
        aria-label={getLabel(
          `accessibility.toggle_underline`,
          `Toggle underline`,
        )}
        pressed={editor.isActive("underline")}
        onClick={() => editor.chain().focus().toggleUnderline().run()}
        {...props}
      >
        <UnderlineIcon className="size-4" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorUnderline;
