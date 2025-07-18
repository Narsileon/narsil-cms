import { Editor } from "@tiptap/react";
import { Toggle } from "@/components/ui/toggle";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";
import {
  Heading1Icon,
  Heading2Icon,
  Heading3Icon,
  Heading4Icon,
  Heading5Icon,
  Heading6Icon,
} from "lucide-react";

type RichTextEditorHeadingProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
  level: 1 | 2 | 3 | 4 | 5 | 6;
};

function RichTextEditorHeading({
  editor,
  level,
  ...props
}: RichTextEditorHeadingProps) {
  const { getLabel } = useLabels();

  return (
    <Tooltip tooltip={getLabel(`accessibility.toggle_heading_${level}`)}>
      <Toggle
        aria-label={getLabel(
          `accessibility.toggle_heading_${level}`,
          `Toggle heading ${level}`,
        )}
        pressed={editor.isActive("heading")}
        onClick={() =>
          editor.chain().focus().toggleHeading({ level: level }).run()
        }
        {...props}
      >
        {level === 1 ? (
          <Heading1Icon className="size-4" />
        ) : level === 2 ? (
          <Heading2Icon className="size-4" />
        ) : level === 3 ? (
          <Heading3Icon className="size-4" />
        ) : level === 4 ? (
          <Heading4Icon className="size-4" />
        ) : level === 5 ? (
          <Heading5Icon className="size-4" />
        ) : level === 6 ? (
          <Heading6Icon className="size-4" />
        ) : null}
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorHeading;
