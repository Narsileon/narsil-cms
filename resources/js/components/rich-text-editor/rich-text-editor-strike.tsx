import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

import { Toggle } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import { type IconName } from "@narsil-cms/plugins/icons";

type RichTextEditorStrikeProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  icon?: IconName;
};

function RichTextEditorStrike({
  editor,
  icon = "strikethrough",
  ...props
}: RichTextEditorStrikeProps) {
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

  const tooltip = trans(`accessibility.toggle_strike`, `Toggle strike`);

  return (
    <Toggle
      disabled={!canStrike}
      pressed={isStrike}
      size="icon"
      tooltip={tooltip}
      onClick={() => editor.chain().focus().toggleStrike().run()}
      {...props}
    >
      <Icon name={icon} />
    </Toggle>
  );
}

export default RichTextEditorStrike;
