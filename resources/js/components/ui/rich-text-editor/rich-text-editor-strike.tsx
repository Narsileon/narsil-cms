import { Editor, useEditorState } from "@tiptap/react";
import { StrikethroughIcon } from "lucide-react";
import { Toggle } from "@/components/ui/toggle";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";

type RichTextEditorStrikeProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorStrike({ editor, ...props }: RichTextEditorStrikeProps) {
  const { getLabel } = useLabels();

  const { canStrike, isStrike } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canStrike: ctx.editor.can().chain().focus().toggleStrike().run(),
        isStrike: ctx.editor.isActive("strike"),
      };
    },
  });

  return (
    <Tooltip tooltip={getLabel(`accessibility.toggle_strike`)} asChild={false}>
      <Toggle
        aria-label={getLabel(`accessibility.toggle_strike`, `Toggle strike`)}
        disabled={!canStrike}
        pressed={isStrike}
        onClick={() => editor.chain().focus().toggleStrike().run()}
        {...props}
      >
        <StrikethroughIcon className="size-5" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorStrike;
