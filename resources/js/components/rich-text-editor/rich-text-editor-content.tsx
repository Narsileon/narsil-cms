import { EditorContent, useCurrentEditor } from "@tiptap/react";
import { type ComponentProps } from "react";

type RichTextEditorContentProps = Omit<ComponentProps<typeof EditorContent>, "editor">;

function RichTextEditorContent({ ...props }: RichTextEditorContentProps) {
  const { editor } = useCurrentEditor();

  return <EditorContent editor={editor} {...props} />;
}

export default RichTextEditorContent;
