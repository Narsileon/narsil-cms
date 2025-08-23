import * as React from "react";
import { Editor, useEditorState } from "@tiptap/react";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Toggle } from "@narsil-cms/components/ui/toggle";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";

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
    <Tooltip
      asChild={true}
      tooltip={trans(`accessibility.toggle_ordered_list`)}
    >
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
