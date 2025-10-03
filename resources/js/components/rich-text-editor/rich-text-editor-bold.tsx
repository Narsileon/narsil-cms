import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

import { Toggle } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { type IconName } from "@narsil-cms/plugins/icons";

type RichTextEditorBoldProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  icon?: IconName;
};

function RichTextEditorBold({
  editor,
  icon = "bold",
  ...props
}: RichTextEditorBoldProps) {
  const { trans } = useLocalization();

  const { canBold, isBold } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canBold: ctx.editor.can().chain().focus().toggleBold().run(),
        isBold: ctx.editor.isActive("bold"),
      };
    },
  });

  const tooltip = trans("accessibility.toggle_bold");

  return (
    <Toggle
      disabled={!canBold}
      pressed={isBold}
      size="icon"
      tooltip={tooltip}
      onClick={() => editor.chain().focus().toggleBold().run()}
      {...props}
    >
      <Icon name={icon} />
    </Toggle>
  );
}

export default RichTextEditorBold;
