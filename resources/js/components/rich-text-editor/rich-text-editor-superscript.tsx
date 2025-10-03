import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

import { Toggle } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { type IconName } from "@narsil-cms/plugins/icons";

type RichTextEditorSuperscriptProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  icon?: IconName;
};

function RichTextEditorSuperscript({
  editor,
  icon = "superscript",
  ...props
}: RichTextEditorSuperscriptProps) {
  const { trans } = useLocalization();

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

  const tooltip = trans("accessibility.toggle_superscript");

  return (
    <Toggle
      disabled={!canSuperscript}
      pressed={isSuperscript}
      size="icon"
      tooltip={tooltip}
      onClick={() => {
        editor.chain().focus().unsetSubscript().run();
        editor.chain().focus().toggleSuperscript().run();
      }}
      {...props}
    >
      <Icon name={icon} />
    </Toggle>
  );
}

export default RichTextEditorSuperscript;
