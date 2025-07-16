import { BoldIcon } from "lucide-react";
import { Editor } from "@tiptap/react";
import { Toggle } from "@/components/ui/toggle";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";

type BoldToggleProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function BoldToggle({ editor, ...props }: BoldToggleProps) {
  const { getLabel } = useLabels();

  return (
    <Tooltip tooltip={getLabel(`accessibility.toggle_bold`)}>
      <Toggle
        aria-label={getLabel(`accessibility.toggle_bold`, `Toggle bold`)}
        pressed={editor.isActive("bold")}
        onClick={() => editor.chain().focus().toggleBold().run()}
        {...props}
      >
        <BoldIcon className="h-4 w-4" />
      </Toggle>
    </Tooltip>
  );
}

export default BoldToggle;
