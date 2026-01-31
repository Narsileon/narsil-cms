import { Icon } from "@narsil-cms/blocks/icon";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { Toggle } from "@narsil-cms/components/toggle";
import { Editor, useEditorState } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorSubscriptProps = ComponentProps<typeof Toggle> & {
  editor: Editor;
  label?: string;
};

function RichTextEditorSubscript({
  editor,
  label = "Subscript",
  ...props
}: RichTextEditorSubscriptProps) {
  const { canSubscript, isSubscript } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canSubscript: ctx.editor.can().chain().focus().toggleSubscript().run(),
        isSubscript: ctx.editor.isActive("subscript"),
      };
    },
  });

  return (
    <Tooltip tooltip={label}>
      <Toggle
        aria-label={label}
        disabled={!canSubscript}
        pressed={isSubscript}
        size="icon"
        onClick={() => {
          editor.chain().focus().unsetSuperscript().run();
          editor.chain().focus().toggleSubscript().run();
        }}
        {...props}
      >
        <Icon name="subscript" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorSubscript;
