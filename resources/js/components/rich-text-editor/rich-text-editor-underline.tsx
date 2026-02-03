import { Icon } from "@narsil-cms/components/icon";
import { Toggle } from "@narsil-cms/components/toggle";
import { Tooltip } from "@narsil-cms/components/tooltip";
import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorUnderlineProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  label?: string;
};

function RichTextEditorUnderline({
  editor,
  label = "Underline",
  ...props
}: RichTextEditorUnderlineProps) {
  const { canUnderline, isUnderline } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canUnderline: ctx.editor.can().chain().focus().toggleUnderline().run(),
        isUnderline: ctx.editor.isActive("underline"),
      };
    },
  });

  return (
    <Tooltip tooltip={label}>
      <Toggle
        aria-label={label}
        disabled={!canUnderline}
        pressed={isUnderline}
        size="icon"
        onClick={() => editor.chain().focus().toggleUnderline().run()}
        {...props}
      >
        <Icon name="underline" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorUnderline;
