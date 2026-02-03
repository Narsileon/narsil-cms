import { Icon } from "@narsil-cms/components/icon";
import { Toggle } from "@narsil-cms/components/toggle";
import { Tooltip } from "@narsil-cms/components/tooltip";
import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorBoldProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  label?: string;
};

function RichTextEditorBold({ editor, label = "Bold", ...props }: RichTextEditorBoldProps) {
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
    <Tooltip tooltip={label}>
      <Toggle
        aria-label={label}
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
