import { Editor, useEditorState } from "@tiptap/react";
import { ItalicIcon } from "lucide-react";
import { Toggle } from "@/components/ui/toggle";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";

type RichTextEditorItalicProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorItalic({ editor, ...props }: RichTextEditorItalicProps) {
  const { getLabel } = useLabels();

  const { canItalic, isItalic } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canItalic: ctx.editor.can().chain().focus().toggleItalic().run(),
        isItalic: ctx.editor.isActive("italic"),
      };
    },
  });

  return (
    <Tooltip tooltip={getLabel(`accessibility.toggle_italic`)} asChild={false}>
      <Toggle
        aria-label={getLabel(`accessibility.toggle_italic`, `Toggle italic`)}
        disabled={!canItalic}
        pressed={isItalic}
        size="icon"
        onClick={() => editor.chain().focus().toggleItalic().run()}
        {...props}
      >
        <ItalicIcon className="size-5" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorItalic;
