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

type RichTextEditorTextAlignProps = React.ComponentProps<typeof Toggle> & {
  alignment: "left" | "center" | "right" | "justify";
  editor: Editor;
};

function RichTextEditorTextAlign({
  alignment,
  editor,
  ...props
}: RichTextEditorTextAlignProps) {
  const { getLabel } = useLabels();

  return (
    <Tooltip
      tooltip={getLabel(`accessibility.align_${alignment}`)}
      asChild={false}
    >
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
          <AlignLeftIcon className="size-5" />
        ) : alignment === "center" ? (
          <AlignCenterIcon className="size-5" />
        ) : alignment === "right" ? (
          <AlignRightIcon className="size-5" />
        ) : alignment === "justify" ? (
          <AlignJustifyIcon className="size-5" />
        ) : null}
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorTextAlign;
