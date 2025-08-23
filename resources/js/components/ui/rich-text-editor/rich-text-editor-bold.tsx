import * as React from "react";
import { Editor, useEditorState } from "@tiptap/react";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Toggle } from "@narsil-cms/components/ui/toggle";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";

type RichTextEditorBoldProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorBold({ editor, ...props }: RichTextEditorBoldProps) {
  const { trans } = useLabels();

  const { canBold, isBold } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canBold: ctx.editor.can().chain().focus().toggleBold().run(),
        isBold: ctx.editor.isActive("bold"),
      };
    },
  });

  return (
    <Tooltip asChild={true} tooltip={trans(`accessibility.toggle_bold`)}>
      <Toggle
        aria-label={trans(`accessibility.toggle_bold`, `Toggle bold`)}
        disabled={!canBold}
        pressed={isBold}
        size="icon"
        onClick={() => editor.chain().focus().toggleBold().run()}
        {...props}
      >
        <Icon name="bold" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorBold;
