import { Icon } from "@narsil-cms/components/icon";
import { Toggle } from "@narsil-cms/components/toggle";
import { Tooltip } from "@narsil-cms/components/tooltip";
import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorOrderedListProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  label?: string;
};

function RichTextEditorOrderedList({
  editor,
  label = "Ordered list",
  ...props
}: RichTextEditorOrderedListProps) {
  const { isOrderedList } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        isOrderedList: ctx.editor.isActive("orderedList"),
      };
    },
  });

  return (
    <Tooltip tooltip={label}>
      <Toggle
        aria-label={label}
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
