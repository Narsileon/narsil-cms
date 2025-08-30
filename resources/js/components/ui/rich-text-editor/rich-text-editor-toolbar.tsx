import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { Editor } from "@tiptap/react";
import { Icon } from "@narsil-cms/components/ui/icon";
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
  modules: string[];
};

function RichTextEditorToolbar({
  className,
  editor,
  modules,
  ...props
}: RichTextEditorToolbarProps) {
  const { trans } = useLabels();

  const headings = [1, 2, 3, 4, 5, 6] as const;

  if (!editor) {
    return null;
  }

  function hasModule(key: string) {
    return modules?.includes(key);
  }

  function hasModules(keys: string[]) {
    return keys?.some((key) => modules?.includes(key));
  }

  return (
    <div
      className={cn(
        "border-color border-color flex h-11 flex-wrap items-center gap-1 border-b px-1",
        className,
      )}
      {...props}
    >
      {/* Basic styles */}
      {hasModule("bold") && <RichTextEditorBold editor={editor} />}
      {hasModule("italic") && <RichTextEditorItalic editor={editor} />}
      {hasModule("underline") && <RichTextEditorUnderline editor={editor} />}
      {hasModule("strike") && <RichTextEditorStrike editor={editor} />}

      {/* Advanced styles */}
      {hasModules(["superscript", "subscript"]) && (
        <>
          <Separator orientation="vertical" />

          {hasModule("superscript") !== false && (
            <RichTextEditorSuperscript editor={editor} />
          )}
          {hasModule("subscript") !== false && (
            <RichTextEditorSubscript editor={editor} />
          )}
        </>
      )}

      {/* Headings */}
      {hasModules(headings.map((level) => `heading_${level}`)) && (
        <>
          <Separator orientation="vertical" />
          <DropdownMenu>
            <Tooltip tooltip={trans(`accessibility.toggle_heading_menu`)}>
              <DropdownMenuTrigger asChild={true}>
                <Button
                  className="w-8 min-w-8"
                  aria-label={trans(
                    `accessibility.toggle_heading_menu`,
                    "Toggle heading menu",
                  )}
                  size="icon"
                  variant="ghost"
                >
                  <Icon name="heading" />
                </Button>
              </DropdownMenuTrigger>
            </Tooltip>
            <DropdownMenuContent className="min-w-9">
              {headings
                .filter((level) => hasModule(`heading_${level}`) !== false)
                .map((level) => (
                  <DropdownMenuItem asChild={true} key={level}>
                    <RichTextEditorHeading editor={editor} level={level} />
                  </DropdownMenuItem>
                ))}
            </DropdownMenuContent>
          </DropdownMenu>
        </>
      )}

      {/* Alignment */}
      {hasModules([
        "align_left",
        "align_center",
        "align_right",
        "align_justify",
      ]) && (
        <>
          <Separator orientation="vertical" />

          {hasModule("align_left") !== false && (
            <RichTextEditorTextAlign alignment="left" editor={editor} />
          )}
          {hasModule("align_center") !== false && (
            <RichTextEditorTextAlign alignment="center" editor={editor} />
          )}
          {hasModule("align_right") !== false && (
            <RichTextEditorTextAlign alignment="right" editor={editor} />
          )}
          {hasModule("align_justify") !== false && (
            <RichTextEditorTextAlign alignment="justify" editor={editor} />
          )}
        </>
      )}

      {/* Lists */}
      {hasModules(["bullet_list", "ordered_list"]) && (
        <>
          <Separator orientation="vertical" />

          {hasModule("bullet_list") && (
            <RichTextEditorBulletList editor={editor} />
          )}
          {hasModule("ordered_list") && (
            <RichTextEditorOrderedList editor={editor} />
          )}
        </>
      )}

      {/* Controls */}
      {hasModules(["undo", "redo"]) && (
        <>
          <Separator orientation="vertical" />

          {hasModule("undo") && <RichTextEditorUndo editor={editor} />}
          {hasModule("redo") && <RichTextEditorRedo editor={editor} />}
        </>
      )}
    </div>
  );
}

export default RichTextEditorToolbar;
