import { Icon } from "@narsil-cms/blocks/icon";
import { Toggle } from "@narsil-cms/components/toggle";
import { Tooltip } from "@narsil-cms/components/tooltip";
import { Editor } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorTextAlignProps = ComponentProps<typeof Toggle> & {
  alignment: "left" | "center" | "right" | "justify";
  editor: Editor;
  label?: string;
};

function RichTextEditorTextAlign({
  alignment,
  editor,
  label,
  ...props
}: RichTextEditorTextAlignProps) {
  if (!label) {
    switch (alignment) {
      case "left":
        label = "Align left";
        break;
      case "center":
        label = "Align center";
        break;
      case "right":
        label = "Align right";
        break;
      case "justify":
        label = "Justify";
        break;
    }
  }

  return (
    <Tooltip tooltip={label}>
      <Toggle
        aria-label={label}
        pressed={editor.isActive({ textAlign: alignment })}
        size="icon"
        onClick={() => editor.chain().focus().setTextAlign(alignment).run()}
        {...props}
      >
        <Icon name={`align-${alignment}`} />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorTextAlign;
