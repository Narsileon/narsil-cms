import { Editor, useEditorState } from "@tiptap/react";
import { SubscriptIcon } from "lucide-react";
import { Toggle } from "@/components/ui/toggle";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";

type RichTextEditorSubscriptProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorSubscript({
  editor,
  ...props
}: RichTextEditorSubscriptProps) {
  const { getLabel } = useLabels();

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
    <Tooltip
      tooltip={getLabel(`accessibility.toggle_subscript`)}
      asChild={false}
    >
      <Toggle
        aria-label={getLabel(
          `accessibility.toggle_subscript`,
          `Toggle subscript`,
        )}
        disabled={!canSubscript}
        pressed={isSubscript}
        onClick={() => {
          editor.chain().focus().unsetSuperscript().run();
          editor.chain().focus().toggleSubscript().run();
        }}
        {...props}
      >
        <SubscriptIcon className="size-5" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorSubscript;
