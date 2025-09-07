import * as React from "react";
import { Editor } from "@tiptap/react";
import { Icon } from "@narsil-cms/components/ui/icon";
import { ToggleRoot } from "@narsil-cms/components/ui/toggle";
import { Tooltip } from "@narsil-cms/blocks";
import { useLabels } from "@narsil-cms/components/ui/labels";

type RichTextEditorTextAlignProps = React.ComponentProps<typeof ToggleRoot> & {
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
      <ToggleRoot
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
      </ToggleRoot>
    </Tooltip>
  );
}

export default RichTextEditorTextAlign;
