import { Editor } from "@tiptap/react";
import { Toggle } from "@/components/ui/toggle";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";
import {
  AlignCenterIcon,
  AlignJustifyIcon,
  AlignLeftIcon,
  AlignRightIcon,
} from "lucide-react";

type TextAlignToggleProps = React.ComponentProps<typeof Toggle> & {
  alignment: "left" | "center" | "right" | "justify";
  editor: Editor;
};

function TextAlignToggle({
  alignment,
  editor,
  ...props
}: TextAlignToggleProps) {
  const { getLabel } = useLabels();

  return (
    <Tooltip tooltip={getLabel(`accessibility.align_${alignment}`)}>
      <Toggle
        aria-label={getLabel(
          `accessibility.align_${alignment}`,
          `Align ${alignment}`,
        )}
        pressed={editor.isActive({ textAlign: alignment })}
        onClick={() => editor.chain().focus().setTextAlign(alignment).run()}
        {...props}
      >
        {alignment === "left" ? (
          <AlignLeftIcon className="h-4 w-4" />
        ) : alignment === "center" ? (
          <AlignCenterIcon className="h-4 w-4" />
        ) : alignment === "right" ? (
          <AlignRightIcon className="h-4 w-4" />
        ) : alignment === "justify" ? (
          <AlignJustifyIcon className="h-4 w-4" />
        ) : null}
      </Toggle>
    </Tooltip>
  );
}

export default TextAlignToggle;
