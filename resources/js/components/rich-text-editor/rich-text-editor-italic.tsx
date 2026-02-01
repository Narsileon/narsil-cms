import { Icon } from "@narsil-cms/blocks/icon";
import { Toggle } from "@narsil-cms/components/toggle";
import { Tooltip } from "@narsil-cms/components/tooltip";
import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorItalicProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  label?: string;
};

function RichTextEditorItalic({ editor, label = "Italic", ...props }: RichTextEditorItalicProps) {
  const { canItalic, isItalic } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canItalic: ctx.editor.can().chain().focus().toggleItalic().run(),
        isItalic: ctx.editor.isActive("italic"),
      };
    },
  });

  return (
    <Tooltip tooltip={label}>
      <Toggle
        aria-label={label}
        disabled={!canItalic}
        pressed={isItalic}
        size="icon"
        onClick={() => editor.chain().focus().toggleItalic().run()}
        {...props}
      >
        <Icon name="italic" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorItalic;
