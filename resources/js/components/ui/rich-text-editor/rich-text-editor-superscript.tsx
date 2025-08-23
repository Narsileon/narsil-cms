import * as React from "react";
import { Editor, useEditorState } from "@tiptap/react";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Toggle } from "@narsil-cms/components/ui/toggle";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";

type RichTextEditorSuperscriptProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorSuperscript({
  editor,
  ...props
}: RichTextEditorSuperscriptProps) {
  const { trans } = useLabels();

  const { canSuperscript, isSuperscript } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canSuperscript: ctx.editor
          .can()
          .chain()
          .focus()
          .toggleSuperscript()
          .run(),
        isSuperscript: ctx.editor.isActive("superscript"),
      };
    },
  });

  return (
    <Tooltip asChild={true} tooltip={trans(`accessibility.toggle_superscript`)}>
      <Toggle
        aria-label={trans(
          `accessibility.toggle_superscript`,
          `Toggle superscript`,
        )}
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
