import { Editor, useEditorState } from "@tiptap/react";
import { Toggle } from "@narsil-cms/components/ui/toggle";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";
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

  const { isHeading } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        isHeading: ctx.editor.isActive("heading", { level: level }),
      };
    },
  });

  return (
    <Tooltip
      tooltip={getLabel(`accessibility.toggle_heading_${level}`)}
      asChild={false}
    >
      <Toggle
        aria-label={getLabel(
          `accessibility.toggle_heading_${level}`,
          `Toggle heading ${level}`,
        )}
        pressed={isHeading}
        size="icon"
        onClick={() =>
          editor.chain().focus().toggleHeading({ level: level }).run()
        }
        {...props}
      >
        {level === 1 ? (
          <Heading1Icon className="size-5" />
        ) : level === 2 ? (
          <Heading2Icon className="size-5" />
        ) : level === 3 ? (
          <Heading3Icon className="size-5" />
        ) : level === 4 ? (
          <Heading4Icon className="size-5" />
        ) : level === 5 ? (
          <Heading5Icon className="size-5" />
        ) : level === 6 ? (
          <Heading6Icon className="size-5" />
        ) : null}
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorHeading;
