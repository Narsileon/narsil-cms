import { Editor, useEditorState } from "@tiptap/react";

import { Tooltip } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import { ToggleRoot } from "@narsil-cms/components/toggle";

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
