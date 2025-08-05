import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { Editor, useEditorState } from "@tiptap/react";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";

type RichTextEditorRedoProps = React.ComponentProps<typeof Button> & {
  editor: Editor;
};

function RichTextEditorRedo({ editor, ...props }: RichTextEditorRedoProps) {
  const { getLabel } = useLabels();

  const { canRedo } = useEditorState({
    editor,
    selector: (ctx) => {
      return {
        canRedo: ctx.editor.can().chain().focus().redo().run(),
      };
    },
  });

  return (
    <Tooltip tooltip={getLabel(`accessibility.redo`)}>
      <Button
        aria-label={getLabel(`accessibility.redo`)}
        disabled={!canRedo}
        size="icon"
        variant="ghost"
        onClick={() => editor.chain().focus().redo().run()}
        {...props}
      >
        <Icon name="redo" />
      </Button>
    </Tooltip>
  );
}

export default RichTextEditorRedo;
