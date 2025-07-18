import { Editor, useEditorState } from "@tiptap/react";
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

  const { canUnderline, isUnderline } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canUnderline: ctx.editor.can().chain().focus().toggleUnderline().run(),
        isUnderline: ctx.editor.isActive("underline"),
      };
    },
  });

  return (
    <Tooltip
      tooltip={getLabel(`accessibility.toggle_underline`)}
      asChild={false}
    >
      <Toggle
        aria-label={getLabel(
          `accessibility.toggle_underline`,
          `Toggle underline`,
        )}
        disabled={!canUnderline}
        pressed={isUnderline}
        onClick={() => editor.chain().focus().toggleUnderline().run()}
        {...props}
      >
        <UnderlineIcon className="size-5" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorUnderline;
