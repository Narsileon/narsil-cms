import { EditorContent, useCurrentEditor } from "@tiptap/react";

type RichTextEditorContentProps = Omit<
  React.ComponentProps<typeof EditorContent>,
  "editor"
> & {};

function RichTextEditorContent({ id, ...props }: RichTextEditorContentProps) {
  const { editor } = useCurrentEditor();

  return <EditorContent id={id} editor={editor} {...props} />;
}

export default RichTextEditorContent;
