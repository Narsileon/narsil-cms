import * as React from "react";
import { Editor, useEditorState } from "@tiptap/react";
import { Icon } from "@narsil-cms/components/ui/icon";
import { ToggleRoot } from "@narsil-cms/components/ui/toggle";
import { Tooltip } from "@narsil-cms/blocks";
import { useLabels } from "@narsil-cms/components/ui/labels";

type RichTextEditorSuperscriptProps = React.ComponentProps<
  typeof ToggleRoot
> & {
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
    <Tooltip tooltip={trans(`accessibility.toggle_superscript`)}>
      <ToggleRoot
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
      </ToggleRoot>
    </Tooltip>
  );
}

export default RichTextEditorSuperscript;
