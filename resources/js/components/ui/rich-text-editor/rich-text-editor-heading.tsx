import * as React from "react";
import { Editor, useEditorState } from "@tiptap/react";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Toggle } from "@narsil-cms/components/ui/toggle";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";

type RichTextEditorHeadingProps = React.ComponentProps<typeof Toggle> & {
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
      <Toggle
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
        <Icon name={`heading-${level}`} />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorHeading;
