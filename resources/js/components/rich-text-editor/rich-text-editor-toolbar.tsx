import { Button, Separator, Tooltip } from "@narsil-cms/blocks";
import {
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuRoot,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";
import { useCurrentEditor } from "@tiptap/react";
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

type RichTextEditorToolbarProps = React.HTMLAttributes<HTMLDivElement> & {
  modules: string[];
};

const headings = [1, 2, 3, 4, 5, 6] as const;

function RichTextEditorToolbar({ className, modules, ...props }: RichTextEditorToolbarProps) {
  const { editor } = useCurrentEditor();
  const { trans } = useLocalization();

  if (!editor || !editor.isEditable) {
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

          {hasModule("superscript") !== false && <RichTextEditorSuperscript editor={editor} />}
          {hasModule("subscript") !== false && <RichTextEditorSubscript editor={editor} />}
        </>
      )}

      {/* Headings */}
      {hasModules(headings.map((level) => `heading_${level}`)) && (
        <>
          <Separator orientation="vertical" />
          <DropdownMenuRoot>
            <Tooltip tooltip={trans("rich-text-editor.toggles.heading_menu")}>
              <DropdownMenuTrigger asChild={true}>
                <Button
                  icon="heading"
                  size="icon"
                  tooltip={trans("rich-text-editor.toggles.heading_menu")}
                  variant="ghost"
                />
              </DropdownMenuTrigger>
            </Tooltip>
            <DropdownMenuContent className="min-w-9">
              {headings
                .filter((level) => hasModule(`heading_${level}`) !== false)
                .map((level) => {
                  return (
                    <DropdownMenuItem asChild={true} key={level}>
                      <RichTextEditorHeading editor={editor} level={level} />
                    </DropdownMenuItem>
                  );
                })}
            </DropdownMenuContent>
          </DropdownMenuRoot>
        </>
      )}

      {/* Alignment */}
      {hasModules(["align_left", "align_center", "align_right", "align_justify"]) && (
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

          {hasModule("bullet_list") && <RichTextEditorBulletList editor={editor} />}
          {hasModule("ordered_list") && <RichTextEditorOrderedList editor={editor} />}
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
