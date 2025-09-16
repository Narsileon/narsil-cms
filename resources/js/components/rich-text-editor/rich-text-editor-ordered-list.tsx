import { Editor, useEditorState } from "@tiptap/react";

import { Toggle, Tooltip } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";

type RichTextEditorOrderedListProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorOrderedList({
  editor,
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

  return (
    <Tooltip tooltip={trans(`accessibility.toggle_ordered_list`)}>
      <Toggle
        aria-label={trans(
          `accessibility.toggle_ordered_list`,
          `Toggle ordered list`,
        )}
        pressed={isOrderedList}
        size="icon"
        onClick={() => editor.chain().focus().toggleOrderedList().run()}
        {...props}
      >
        <Icon name="list-ordered" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorOrderedList;
