import { Editor, useEditorState } from "@tiptap/react";

import { Toggle, Tooltip } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import { type IconName } from "@narsil-cms/plugins/icons";

type RichTextEditorSubscriptProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
  icon?: IconName;
};

function RichTextEditorSubscript({
  editor,
  icon = "subscript",
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
      <Toggle
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
        <Icon name={icon} />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorSubscript;
