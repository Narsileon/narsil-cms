import { Button } from "@/components/ui/button";
import { Editor } from "@tiptap/react";
import { Tooltip } from "@/components/ui/tooltip";
import { RedoIcon } from "lucide-react";
import { useLabels } from "@/components/ui/labels";

type RichTextEditorRedoProps = React.ComponentProps<typeof Button> & {
  editor: Editor;
};

function RichTextEditorRedo({ editor, ...props }: RichTextEditorRedoProps) {
  const { getLabel } = useLabels();

  return (
    <Tooltip tooltip={getLabel(`accessibility.redo`)}>
      <Button
        aria-label={getLabel(`accessibility.redo`)}
        disabled={!editor.can().chain().focus().redo().run()}
        size="icon"
        type="button"
        variant="ghost"
        onClick={() => editor.chain().focus().redo().run()}
        {...props}
      >
        <RedoIcon className="size-4" />
      </Button>
    </Tooltip>
  );
}

export default RichTextEditorRedo;
