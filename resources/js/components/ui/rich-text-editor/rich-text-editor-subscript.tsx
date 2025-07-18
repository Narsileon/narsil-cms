import { Editor } from "@tiptap/react";
import { SubscriptIcon } from "lucide-react";
import { Toggle } from "@/components/ui/toggle";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";

type RichTextEditorSubscriptProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorSubscript({
  editor,
  ...props
}: RichTextEditorSubscriptProps) {
  const { getLabel } = useLabels();

  return (
    <Tooltip tooltip={getLabel(`accessibility.toggle_subscript`)}>
      <Toggle
        aria-label={getLabel(
          `accessibility.toggle_subscript`,
          `Toggle subscript`,
        )}
        pressed={editor.isActive("subscript")}
        onClick={() => {
          editor.chain().focus().unsetSuperscript().run();
          editor.chain().focus().toggleSubscript().run();
        }}
        {...props}
      >
        <SubscriptIcon className="size-4" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorSubscript;
