import Subscript from "@tiptap/extension-subscript";
import Superscript from "@tiptap/extension-superscript";
import TextAlign from "@tiptap/extension-text-align";
import { Placeholder } from "@tiptap/extensions";
import { EditorContext, EditorOptions, useEditor } from "@tiptap/react";
import StarterKit from "@tiptap/starter-kit";
import { useEffect, useMemo } from "react";

import { cn } from "@narsil-cms/lib/utils";

type RichTextEditorRootProps = Partial<EditorOptions> & {
  children?: React.ReactNode;
  className?: string;
  placeholder?: string;
  value: string;
  onChange?: (value: string) => void;
};

function RichTextEditorProvider({
  children,
  className,
  placeholder,
  value,
  onChange,
  ...props
}: RichTextEditorRootProps) {
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
          "rounded-md rounded-t-none bg-background px-3 py-2 ring-offset-background",
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

  const providerValue = useMemo(() => ({ editor }), [editor]);

  return (
    <EditorContext.Provider value={providerValue}>
      {children}
    </EditorContext.Provider>
  );
}

export default RichTextEditorProvider;
