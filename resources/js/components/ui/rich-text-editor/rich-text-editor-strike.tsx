import * as React from "react";
import { Editor, useEditorState } from "@tiptap/react";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Toggle } from "@narsil-cms/components/ui/toggle";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";

type RichTextEditorStrikeProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorStrike({ editor, ...props }: RichTextEditorStrikeProps) {
  const { trans } = useLabels();

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
    <Tooltip asChild={true} tooltip={trans(`accessibility.toggle_strike`)}>
      <Toggle
        aria-label={trans(`accessibility.toggle_strike`, `Toggle strike`)}
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
