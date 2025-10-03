import { Editor } from "@tiptap/react";
import { type ComponentProps } from "react";

import { Toggle } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";

type RichTextEditorTextAlignProps = ComponentProps<typeof Toggle> & {
  alignment: "left" | "center" | "right" | "justify";
  editor: Editor;
};

function RichTextEditorTextAlign({
  alignment,
  editor,
  ...props
}: RichTextEditorTextAlignProps) {
  const { trans } = useLocalization();

  const tooltip = trans("accessibility.align_${alignment}");

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
