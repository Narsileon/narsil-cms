import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

import { Toggle } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { type IconName } from "@narsil-cms/plugins/icons";

type RichTextEditorOrderedListProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  icon?: IconName;
};

function RichTextEditorOrderedList({
  editor,
  icon = "list-ordered",
  ...props
}: RichTextEditorOrderedListProps) {
  const { trans } = useLocalization();

  const { isOrderedList } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        isOrderedList: ctx.editor.isActive("orderedList"),
      };
    },
  });

  const tooltip = trans("rich-text-editor.toggles.ordered_list");

  return (
    <Toggle
      pressed={isOrderedList}
      size="icon"
      tooltip={tooltip}
      onClick={() => editor.chain().focus().toggleOrderedList().run()}
      {...props}
    >
      <Icon name={icon} />
    </Toggle>
  );
}

export default RichTextEditorOrderedList;
