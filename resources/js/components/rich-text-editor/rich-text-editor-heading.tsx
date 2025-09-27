import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

import { Toggle } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";

type RichTextEditorHeadingProps = ComponentProps<typeof Toggle> & {
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

  const tooltip = trans(
    `accessibility.toggle_heading_${level}`,
    `Toggle heading ${level}`,
  );

  return (
    <Toggle
      pressed={isHeading}
      size="icon"
      tooltip={tooltip}
      onClick={() =>
        editor.chain().focus().toggleHeading({ level: level }).run()
      }
      {...props}
    >
      <Icon className="stroke-foreground" name={`heading-${level}`} />
    </Toggle>
  );
}

export default RichTextEditorHeading;
