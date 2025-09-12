import { cn } from "@narsil-cms/lib/utils";
import { EditorContent, EditorOptions, useEditor } from "@tiptap/react";
import { Placeholder } from "@tiptap/extensions";
import { useEffect } from "react";
import RichTextEditorToolbar from "./rich-text-editor-toolbar";
import StarterKit from "@tiptap/starter-kit";
import Subscript from "@tiptap/extension-subscript";
import Superscript from "@tiptap/extension-superscript";
import TextAlign from "@tiptap/extension-text-align";

type RichTextEditorProps = Partial<EditorOptions> & {
  className?: string;
  id?: string;
  modules: string[];
  placeholder?: string;
  toolbar?: boolean;
  value: string;
  onChange?: (value: any) => void;
};

function RichTextEditor({
  className,
  id,
  modules,
  placeholder,
  toolbar = true,
  value,
  onChange,
  ...props
}: RichTextEditorProps) {
  const extensions = [
    Placeholder.configure({
      emptyEditorClass:
        "before:pointer-events-none before:float-left before:h-0 before:text-muted-foreground before:content-[attr(data-placeholder)]",
      placeholder: placeholder,
    }),
    StarterKit.configure({
      bulletList: {
        HTMLAttributes: {
          class: "list-disc list-outside ml-6",
        },
      },
      orderedList: {
        HTMLAttributes: {
          class: "list-decimal list-outside ml-6",
        },
      },
    }),
    Subscript,
    Superscript,
    TextAlign.configure({
      alignments: ["left", "center", "right", "justify"],
      types: ["heading", "paragraph"],
    }),
  ];

  const editor = useEditor({
    extensions: extensions,
    content: value,
    editorProps: {
      attributes: {
        class: cn(
          "prose max-w-none !whitespace-normal text-foreground",
          "rounded-md rounded-t-none bg-background px-3 py-2 text-sm ring-offset-background",
          "focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 focus-visible:outline-none",
          "disabled:cursor-not-allowed disabled:opacity-50",
          className,
        ),
      },
    },
    onUpdate: ({ editor }) => {
      onChange?.(editor.getHTML());
    },
    ...props,
  });

  useEffect(() => {
    if (editor && editor?.getHTML() !== value) {
      editor?.commands.setContent(value);
    }
  }, [value]);

  return (
    <div className="border-color flex flex-col rounded-md border">
      {toolbar && editor?.isEditable ? (
        <RichTextEditorToolbar editor={editor} modules={modules} />
      ) : null}

      <EditorContent id={id} editor={editor} />
    </div>
  );
}

export default RichTextEditor;
