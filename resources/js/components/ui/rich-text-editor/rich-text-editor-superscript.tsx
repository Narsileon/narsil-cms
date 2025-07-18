import { Editor } from "@tiptap/react";
import { SuperscriptIcon } from "lucide-react";
import { Toggle } from "@/components/ui/toggle";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";

type RichTextEditorSuperscriptProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorSuperscript({
  editor,
  ...props
}: RichTextEditorSuperscriptProps) {
  const { getLabel } = useLabels();

  return (
    <Tooltip tooltip={getLabel(`accessibility.toggle_superscript`)}>
      <Toggle
        aria-label={getLabel(
          `accessibility.toggle_superscript`,
          `Toggle superscript`,
        )}
        pressed={editor.isActive("superscript")}
        onClick={() => {
          editor.chain().focus().unsetSubscript().run();
          editor.chain().focus().toggleSuperscript().run();
        }}
        {...props}
      >
        <SuperscriptIcon className="size-4" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorSuperscript;
