import { Editor, useEditorState } from "@tiptap/react";
import { SuperscriptIcon } from "lucide-react";
import { Toggle } from "@/components/ui/toggle";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";

type RichTextEditorSuperscriptProps = React.ComponentProps<typeof Toggle> & {
  editor: Editor;
};

function RichTextEditorSuperscript({
  editor,
  ...props
}: RichTextEditorSuperscriptProps) {
  const { getLabel } = useLabels();

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

  return (
    <Tooltip
      tooltip={getLabel(`accessibility.toggle_superscript`)}
      asChild={false}
    >
      <Toggle
        aria-label={getLabel(
          `accessibility.toggle_superscript`,
          `Toggle superscript`,
        )}
        disabled={!canSuperscript}
        pressed={isSuperscript}
        size="icon"
        onClick={() => {
          editor.chain().focus().unsetSubscript().run();
          editor.chain().focus().toggleSuperscript().run();
        }}
        {...props}
      >
        <SuperscriptIcon className="size-5" />
      </Toggle>
    </Tooltip>
  );
}

export default RichTextEditorSuperscript;
