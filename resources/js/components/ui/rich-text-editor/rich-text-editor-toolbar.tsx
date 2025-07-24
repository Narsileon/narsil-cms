import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { Editor } from "@tiptap/react";
import { HeadingIcon } from "lucide-react";
import { Separator } from "@narsil-cms/components/ui/separator";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";
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
} from "@narsil-cms/components/ui/dropdown-menu";

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
    <div
      className={cn(
        "border-color border-color flex h-11 flex-wrap items-center gap-1 border-b px-3",
        className,
      )}
      {...props}
    >
      <RichTextEditorBold editor={editor} />
      <RichTextEditorItalic editor={editor} />
      <RichTextEditorUnderline editor={editor} />
      <RichTextEditorStrike editor={editor} />
      <Separator orientation="vertical" />
      <RichTextEditorSuperscript editor={editor} />
      <RichTextEditorSubscript editor={editor} />
      <Separator orientation="vertical" />
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
              <HeadingIcon className="size-5" />
            </Button>
          </DropdownMenuTrigger>
        </Tooltip>
        <DropdownMenuContent>
          {headings.map((level, index) => {
            return (
              <DropdownMenuItem asChild={true} key={index}>
                <RichTextEditorHeading editor={editor} level={level} />
              </DropdownMenuItem>
            );
          })}
        </DropdownMenuContent>
      </DropdownMenu>
      <Separator orientation="vertical" />
      <RichTextEditorTextAlign alignment="left" editor={editor} />
      <RichTextEditorTextAlign alignment="center" editor={editor} />
      <RichTextEditorTextAlign alignment="right" editor={editor} />
      <RichTextEditorTextAlign alignment="justify" editor={editor} />
      <Separator orientation="vertical" />
      <RichTextEditorBulletList editor={editor} />
      <RichTextEditorOrderedList editor={editor} />
      <Separator orientation="vertical" />
      <RichTextEditorUndo editor={editor} />
      <RichTextEditorRedo editor={editor} />
    </div>
  );
}

export default RichTextEditorToolbar;
