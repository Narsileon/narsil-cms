import { Editor, useEditorState } from "@tiptap/react";
import { Icon } from "@narsil-cms/components/icon";
import { ToggleRoot } from "@narsil-cms/components/toggle";
import { Tooltip } from "@narsil-cms/blocks";
import { useLabels } from "@narsil-cms/components/labels";

type RichTextEditorHeadingProps = React.ComponentProps<typeof ToggleRoot> & {
  editor: Editor;
  level: 1 | 2 | 3 | 4 | 5 | 6;
};

function RichTextEditorHeading({
  editor,
  level,
  ...props
}: RichTextEditorHeadingProps) {
  const { trans } = useLabels();

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
      asChild={true}
      tooltip={trans(`accessibility.toggle_heading_${level}`)}
    >
      <ToggleRoot
        aria-label={trans(
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
        <Icon className="stroke-foreground" name={`heading-${level}`} />
      </ToggleRoot>
    </Tooltip>
  );
}

export default RichTextEditorHeading;
