import { Editor, useEditorState } from "@tiptap/react";
import { Icon } from "@narsil-cms/components/icon";
import { ToggleRoot } from "@narsil-cms/components/toggle";
import { Tooltip } from "@narsil-cms/blocks";
import { useLabels } from "@narsil-cms/components/labels";

type RichTextEditorOrderedListProps = React.ComponentProps<
  typeof ToggleRoot
> & {
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
      <ToggleRoot
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
      </ToggleRoot>
    </Tooltip>
  );
}

export default RichTextEditorOrderedList;
