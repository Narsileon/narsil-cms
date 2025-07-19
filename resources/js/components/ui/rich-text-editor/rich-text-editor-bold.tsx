import { BoldIcon } from "lucide-react";
import { Editor, useEditorState } from "@tiptap/react";
import { Toggle } from "@/components/ui/toggle";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";

type RichTextEditorBoldProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorBold({ editor, ...props }: RichTextEditorBoldProps) {
  const { getLabel } = useLabels();

  const { canBold, isBold } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canBold: ctx.editor.can().chain().focus().toggleBold().run(),
        isBold: ctx.editor.isActive("bold"),
      };
    },
  });

  return (
    <Tooltip tooltip={getLabel(`accessibility.toggle_bold`)} asChild={false}>
      <Toggle
        aria-label={getLabel(`accessibility.toggle_bold`, `Toggle bold`)}
        disabled={!canBold}
        pressed={isBold}
        size="icon"
        onClick={() => editor.chain().focus().toggleBold().run()}
        {...props}
      >
        <BoldIcon className="size-5" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorBold;
