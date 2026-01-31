import { Icon } from "@narsil-cms/blocks/icon";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { Toggle } from "@narsil-cms/components/toggle";
import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorHeadingProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  label?: string;
  level: 1 | 2 | 3 | 4 | 5 | 6;
};

function RichTextEditorHeading({ editor, label, level, ...props }: RichTextEditorHeadingProps) {
  const { isHeading } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        isHeading: ctx.editor.isActive("heading", { level: level }),
      };
    },
  });

  if (!label) {
    label = `Heading ${level}`;
  }

  return (
    <Tooltip tooltip={label}>
      <Toggle
        aria-label={label}
        pressed={isHeading}
        size="icon"
        onClick={() => editor.chain().focus().toggleHeading({ level: level }).run()}
        {...props}
      >
        <Icon className="stroke-foreground" name={`heading-${level}`} />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorHeading;
