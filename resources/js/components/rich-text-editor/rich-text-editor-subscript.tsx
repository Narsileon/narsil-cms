import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

import { Toggle } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { type IconName } from "@narsil-cms/plugins/icons";

type RichTextEditorSubscriptProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  icon?: IconName;
};

function RichTextEditorSubscript({
  editor,
  icon = "subscript",
  ...props
}: RichTextEditorSubscriptProps) {
  const { trans } = useLocalization();

  const { canSubscript, isSubscript } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canSubscript: ctx.editor.can().chain().focus().toggleSubscript().run(),
        isSubscript: ctx.editor.isActive("subscript"),
      };
    },
  });

  const tooltip = trans("rich-text-editor.toggles.subscript");

  return (
    <Toggle
      disabled={!canSubscript}
      pressed={isSubscript}
      size="icon"
      tooltip={tooltip}
      onClick={() => {
        editor.chain().focus().unsetSuperscript().run();
        editor.chain().focus().toggleSubscript().run();
      }}
      {...props}
    >
      <Icon name={icon} />
    </Toggle>
  );
}

export default RichTextEditorSubscript;
