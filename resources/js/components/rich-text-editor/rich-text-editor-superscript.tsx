import { Icon } from "@narsil-cms/blocks/icon";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { Toggle } from "@narsil-cms/components/toggle";
import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorSuperscriptProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  label?: string;
};

function RichTextEditorSuperscript({
  editor,
  label = "Superscript",
  ...props
}: RichTextEditorSuperscriptProps) {
  const { canSuperscript, isSuperscript } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canSuperscript: ctx.editor.can().chain().focus().toggleSuperscript().run(),
        isSuperscript: ctx.editor.isActive("superscript"),
      };
    },
  });

  return (
    <Tooltip tooltip={label}>
      <Toggle
        aria-label={label}
        disabled={!canSuperscript}
        pressed={isSuperscript}
        size="icon"
        onClick={() => {
          editor.chain().focus().unsetSubscript().run();
          editor.chain().focus().toggleSuperscript().run();
        }}
        {...props}
      >
        <Icon name="superscript" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorSuperscript;
