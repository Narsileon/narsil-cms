import { Button } from "@narsil-cms/components/ui/button";
import { Editor, useEditorState } from "@tiptap/react";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { UndoIcon } from "lucide-react";
import { useLabels } from "@narsil-cms/components/ui/labels";

type RichTextEditorUndoProps = React.ComponentProps<typeof Button> & {
  editor: Editor;
};

function RichTextEditorUndo({ editor, ...props }: RichTextEditorUndoProps) {
  const { getLabel } = useLabels();

  const { canUndo } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canUndo: ctx.editor.can().chain().focus().undo().run(),
      };
    },
  });

  return (
    <Tooltip tooltip={getLabel(`accessibility.undo`)}>
      <Button
        aria-label={getLabel(`accessibility.undo`)}
        disabled={!canUndo}
        size="icon"
        variant="ghost"
        onClick={() => editor.chain().focus().undo().run()}
        {...props}
      >
        <UndoIcon className="size-5" />
      </Button>
    </Tooltip>
  );
}

export default RichTextEditorUndo;
