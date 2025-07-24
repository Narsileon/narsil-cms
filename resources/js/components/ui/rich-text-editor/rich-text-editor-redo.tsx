import { Button } from "@narsil-cms/components/ui/button";
import { Editor, useEditorState } from "@tiptap/react";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { RedoIcon } from "lucide-react";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { ca } from "date-fns/locale";

type RichTextEditorRedoProps = React.ComponentProps<typeof Button> & {
  editor: Editor;
};

function RichTextEditorRedo({ editor, ...props }: RichTextEditorRedoProps) {
  const { getLabel } = useLabels();

  const { canRedo } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canRedo: ctx.editor.can().chain().focus().redo().run(),
      };
    },
  });

  return (
    <Tooltip tooltip={getLabel(`accessibility.redo`)}>
      <Button
        aria-label={getLabel(`accessibility.redo`)}
        disabled={!canRedo}
        size="icon"
        type="button"
        variant="ghost"
        onClick={() => editor.chain().focus().redo().run()}
        {...props}
      >
        <RedoIcon className="size-5" />
      </Button>
    </Tooltip>
  );
}

export default RichTextEditorRedo;
