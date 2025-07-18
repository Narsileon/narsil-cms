import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import { Editor } from "@tiptap/react";
import { HeadingIcon } from "lucide-react";
import { Separator } from "@/components/ui/separator";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";
import RichTextEditorBold from "./rich-text-editor-bold";
import RichTextEditorBulletList from "./rich-text-editor-bullet-list";
import RichTextEditorHeading from "./rich-text-editor-heading";
import RichTextEditorItalic from "./rich-text-editor-italic";
import RichTextEditorOrderedList from "./rich-text-editor-ordered-list";
import RichTextEditorRedo from "./rich-text-editor-redo";
import RichTextEditorStrike from "./rich-text-editor-strike";
import RichTextEditorSubscript from "./rich-text-editor-subscript";
import RichTextEditorSuperscript from "./rich-text-editor-superscript";
import RichTextEditorTextAlign from "./rich-text-editor-text-align";
import RichTextEditorUnderline from "./rich-text-editor-underline";
import RichTextEditorUndo from "./rich-text-editor-undo";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";

type RichTextEditorToolbarProps = React.HTMLAttributes<HTMLDivElement> & {
  editor: Editor | null;
};

function RichTextEditorToolbar({
  className,
  editor,
  ...props
}: RichTextEditorToolbarProps) {
  const { getLabel } = useLabels();

  const headings = [1, 2, 3, 4, 5, 6] as const;

  if (!editor) {
    return null;
  }

  return (
    <div className={cn("flex flex-wrap items-center", className)} {...props}>
      <RichTextEditorBold editor={editor} />
      <RichTextEditorItalic editor={editor} />
      <RichTextEditorUnderline editor={editor} />
      <RichTextEditorStrike editor={editor} />

      <Separator className="mx-1 h-9" orientation="vertical" />

      <DropdownMenu>
        <Tooltip tooltip={getLabel(`accessibility.toggle_heading_menu`)}>
          <DropdownMenuTrigger asChild={true}>
            <Button
              className="w-8 min-w-8"
              aria-label={getLabel(
                `accessibility.toggle_heading_menu`,
                "Toggle heading menu",
              )}
              size="icon"
              variant="ghost"
            >
              <HeadingIcon className="size-4" />
            </Button>
          </DropdownMenuTrigger>
        </Tooltip>
        <DropdownMenuContent>
          {headings.map((level, index) => {
            return (
              <DropdownMenuItem asChild={true}>
                <RichTextEditorHeading
                  editor={editor}
                  level={level}
                  key={index}
                />
              </DropdownMenuItem>
            );
          })}
        </DropdownMenuContent>
      </DropdownMenu>
      <RichTextEditorSuperscript editor={editor} />
      <RichTextEditorSubscript editor={editor} />

      <Separator className="mx-1 h-9" orientation="vertical" />

      <RichTextEditorTextAlign alignment="left" editor={editor} />
      <RichTextEditorTextAlign alignment="center" editor={editor} />
      <RichTextEditorTextAlign alignment="right" editor={editor} />
      <RichTextEditorTextAlign alignment="justify" editor={editor} />

      <Separator className="mx-1 h-9" orientation="vertical" />

      <RichTextEditorBulletList editor={editor} />
      <RichTextEditorOrderedList editor={editor} />

      <Separator className="mx-1 h-9" orientation="vertical" />

      <RichTextEditorUndo editor={editor} />
      <RichTextEditorRedo editor={editor} />
    </div>
  );
}

export default RichTextEditorToolbar;
