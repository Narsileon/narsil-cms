import * as React from "react";
import { Editor, useEditorState } from "@tiptap/react";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Toggle } from "@narsil-cms/components/ui/toggle";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";

type RichTextEditorItalicProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorItalic({ editor, ...props }: RichTextEditorItalicProps) {
  const { trans } = useLabels();

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
    <Tooltip tooltip={trans(`accessibility.toggle_italic`)}>
      <Toggle
        aria-label={trans(`accessibility.toggle_italic`, `Toggle italic`)}
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
