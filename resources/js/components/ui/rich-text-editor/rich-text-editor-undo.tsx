import { Button } from "@/components/ui/button";
import { Editor } from "@tiptap/react";
import { Tooltip } from "@/components/ui/tooltip";
import { UndoIcon } from "lucide-react";
import { useLabels } from "@/components/ui/labels";

type RichTextEditorUndoProps = React.ComponentProps<typeof Button> & {
  editor: Editor;
};

function RichTextEditorUndo({ editor, ...props }: RichTextEditorUndoProps) {
  const { getLabel } = useLabels();

  return (
    <Tooltip tooltip={getLabel(`accessibility.undo`)}>
      <Button
        aria-label={getLabel(`accessibility.undo`)}
        disabled={!editor.can().chain().focus().undo().run()}
        size="icon"
        type="button"
        variant="ghost"
        onClick={() => editor.chain().focus().undo().run()}
        {...props}
      >
        <UndoIcon className="size-4" />
      </Button>
    </Tooltip>
  );
}

export default RichTextEditorUndo;
