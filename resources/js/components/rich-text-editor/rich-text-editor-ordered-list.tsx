import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

import { Toggle } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
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
  const { trans } = useLabels();

  const { isOrderedList } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        isOrderedList: ctx.editor.isActive("orderedList"),
      };
    },
  });

  const tooltip = trans(
    `accessibility.toggle_ordered_list`,
    `Toggle ordered list`,
  );

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
