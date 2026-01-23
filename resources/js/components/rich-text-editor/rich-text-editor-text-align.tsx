import { Icon } from "@narsil-cms/blocks/icon";
import { Toggle } from "@narsil-cms/blocks/toggle";
import { useLocalization } from "@narsil-cms/components/localization";
import { Editor } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorTextAlignProps = ComponentProps<typeof Toggle> & {
  alignment: "left" | "center" | "right" | "justify";
  editor: Editor;
};

function RichTextEditorTextAlign({ alignment, editor, ...props }: RichTextEditorTextAlignProps) {
  const { trans } = useLocalization();

  const tooltip = trans(`rich-text-editor.align_${alignment}`);

  return (
    <Toggle
      pressed={editor.isActive({ textAlign: alignment })}
      size="icon"
      tooltip={tooltip}
      onClick={() => editor.chain().focus().setTextAlign(alignment).run()}
      {...props}
    >
      <Icon name={`align-${alignment}`} />
    </Toggle>
  );
}

export default RichTextEditorTextAlign;
