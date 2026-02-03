import { Icon } from "@narsil-cms/components/icon";
import { Toggle } from "@narsil-cms/components/toggle";
import { Tooltip } from "@narsil-cms/components/tooltip";
import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorStrikeProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  label?: string;
};

function RichTextEditorStrike({ editor, label = "Strike", ...props }: RichTextEditorStrikeProps) {
  const { canStrike, isStrike } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canStrike: ctx.editor.can().chain().focus().toggleStrike().run(),
        isStrike: ctx.editor.isActive("strike"),
      };
    },
  });

  return (
    <Tooltip tooltip={label}>
      <Toggle
        aria-label={label}
        disabled={!canStrike}
        pressed={isStrike}
        size="icon"
        onClick={() => editor.chain().focus().toggleStrike().run()}
        {...props}
      >
        <Icon name="strikethrough" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorStrike;
