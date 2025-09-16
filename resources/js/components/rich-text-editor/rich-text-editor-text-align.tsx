import { Editor } from "@tiptap/react";

import { Toggle, Tooltip } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";

type RichTextEditorTextAlignProps = React.ComponentProps<typeof Toggle> & {
  alignment: "left" | "center" | "right" | "justify";
  editor: Editor;
};

function RichTextEditorTextAlign({
  alignment,
  editor,
  ...props
}: RichTextEditorTextAlignProps) {
  const { trans } = useLabels();

  return (
    <Tooltip tooltip={trans(`accessibility.align_${alignment}`)}>
      <Toggle
        aria-label={trans(
          `accessibility.align_${alignment}`,
          `Align ${alignment}`,
        )}
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
