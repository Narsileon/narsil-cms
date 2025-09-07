import * as React from "react";
import { Editor, useEditorState } from "@tiptap/react";
import { Icon } from "@narsil-cms/components/ui/icon";
import { ToggleRoot } from "@narsil-cms/components/ui/toggle";
import { Tooltip } from "@narsil-cms/blocks";
import { useLabels } from "@narsil-cms/components/ui/labels";

type RichTextEditorSubscriptProps = React.ComponentProps<typeof ToggleRoot> & {
  editor: Editor;
};

function RichTextEditorSubscript({
  editor,
  ...props
}: RichTextEditorSubscriptProps) {
  const { trans } = useLabels();

  const { canSubscript, isSubscript } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canSubscript: ctx.editor.can().chain().focus().toggleSubscript().run(),
        isSubscript: ctx.editor.isActive("subscript"),
      };
    },
  });

  return (
    <Tooltip tooltip={trans(`accessibility.toggle_subscript`)}>
      <ToggleRoot
        aria-label={trans(`accessibility.toggle_subscript`, `Toggle subscript`)}
        disabled={!canSubscript}
        pressed={isSubscript}
        size="icon"
        onClick={() => {
          editor.chain().focus().unsetSuperscript().run();
          editor.chain().focus().toggleSubscript().run();
        }}
        {...props}
      >
        <Icon name="subscript" />
      </ToggleRoot>
    </Tooltip>
  );
}

export default RichTextEditorSubscript;
