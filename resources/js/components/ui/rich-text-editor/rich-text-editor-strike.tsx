import { Editor } from "@tiptap/react";
import { StrikethroughIcon } from "lucide-react";
import { Toggle } from "@/components/ui/toggle";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";

type RichTextEditorStrikeProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorStrike({ editor, ...props }: RichTextEditorStrikeProps) {
  const { getLabel } = useLabels();

  return (
    <Tooltip tooltip={getLabel(`accessibility.toggle_strike`)}>
      <Toggle
        aria-label={getLabel(`accessibility.toggle_strike`, `Toggle strike`)}
        pressed={editor.isActive("strike")}
        onClick={() => editor.chain().focus().toggleStrike().run()}
        {...props}
      >
        <StrikethroughIcon className="size-4" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorStrike;
