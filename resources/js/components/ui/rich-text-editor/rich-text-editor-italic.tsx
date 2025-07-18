import { Editor } from "@tiptap/react";
import { ItalicIcon } from "lucide-react";
import { Toggle } from "@/components/ui/toggle";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";

type RichTextEditorItalicProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorItalic({ editor, ...props }: RichTextEditorItalicProps) {
  const { getLabel } = useLabels();

  return (
    <Tooltip tooltip={getLabel(`accessibility.toggle_italic`)}>
      <Toggle
        aria-label={getLabel(`accessibility.toggle_italic`, `Toggle italic`)}
        pressed={editor.isActive("italic")}
        onClick={() => editor.chain().focus().toggleItalic().run()}
        {...props}
      >
        <ItalicIcon className="size-4" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorItalic;
