import { Button } from "@narsil-cms/components/button";
import {
  DropdownMenuPopup,
  DropdownMenuPortal,
  DropdownMenuPositioner,
  DropdownMenuRoot,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { Separator } from "@narsil-cms/components/separator";
import { Tooltip } from "@narsil-cms/components/tooltip";
import { cn } from "@narsil-cms/lib/utils";
import { useCurrentEditor } from "@tiptap/react";
import { ComponentProps } from "react";
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

type RichTextEditorToolbarProps = ComponentProps<"div"> & {
  modules: string[];
};

const headings = [1, 2, 3, 4, 5, 6] as const;

function RichTextEditorToolbar({ className, modules = [], ...props }: RichTextEditorToolbarProps) {
  const { editor } = useCurrentEditor();
  const { trans } = useLocalization();

  if (!editor || !editor.isEditable) {
    return null;
  }

  function hasModule(key: string) {
    if (modules?.length === 0) {
      return true;
    }

    return modules?.includes(key);
  }

  function hasModules(keys: string[]) {
    if (modules?.length === 0) {
      return true;
    }

    return keys?.some((key) => modules?.includes(key));
  }

  return (
    <div
      className={cn(
        "border-color border-color no-scrollbar flex h-11 items-center gap-1 overflow-x-auto border-b px-1",
        className,
      )}
      {...props}
    >
      {/* Basic styles */}
      {hasModule("bold") && (
        <RichTextEditorBold editor={editor} label={trans("rich-text-editor.bold")} />
      )}
      {hasModule("italic") && (
        <RichTextEditorItalic editor={editor} label={trans("rich-text-editor.italic")} />
      )}
      {hasModule("underline") && (
        <RichTextEditorUnderline editor={editor} label={trans("rich-text-editor.underline")} />
      )}
      {hasModule("strike") && (
        <RichTextEditorStrike editor={editor} label={trans("rich-text-editor.strike")} />
      )}

      {/* Advanced styles */}
      {hasModules(["superscript", "subscript"]) && (
        <>
          <Separator orientation="vertical" />

          {hasModule("superscript") && (
            <RichTextEditorSuperscript
              editor={editor}
              label={trans("rich-text-editor.superscript")}
            />
          )}
          {hasModule("subscript") && (
            <RichTextEditorSubscript editor={editor} label={trans("rich-text-editor.subscript")} />
          )}
        </>
      )}

      {/* Headings */}
      {hasModules(headings.map((level) => `heading_${level}`)) && (
        <>
          <Separator orientation="vertical" />
          <DropdownMenuRoot>
            <DropdownMenuTrigger
              render={
                <Tooltip tooltip={trans("rich-text-editor.headings")}>
                  <Button
                    aria-label={trans("rich-text-editor.headings")}
                    size="icon"
                    variant="ghost"
                  >
                    <Icon name="heading" />
                  </Button>
                </Tooltip>
              }
            />
            <DropdownMenuPortal>
              <DropdownMenuPositioner>
                <DropdownMenuPopup className="min-w-9">
                  {headings
                    .filter((level) => hasModule(`heading_${level}`) !== false)
                    .map((level) => {
                      return (
                        <RichTextEditorHeading
                          editor={editor}
                          label={trans(`rich-text-editor.heading_${level}`)}
                          level={level}
                          key={level}
                        />
                      );
                    })}
                </DropdownMenuPopup>
              </DropdownMenuPositioner>
            </DropdownMenuPortal>
          </DropdownMenuRoot>
        </>
      )}

      {/* Alignment */}
      {hasModules(["align_left", "align_center", "align_right", "align_justify"]) && (
        <>
          <Separator orientation="vertical" />

          {hasModule("align_left") && (
            <RichTextEditorTextAlign
              alignment="left"
              editor={editor}
              label={trans(`rich-text-editor.align_left`)}
            />
          )}
          {hasModule("align_center") && (
            <RichTextEditorTextAlign
              alignment="center"
              editor={editor}
              label={trans(`rich-text-editor.align_center`)}
            />
          )}
          {hasModule("align_right") && (
            <RichTextEditorTextAlign
              alignment="right"
              editor={editor}
              label={trans(`rich-text-editor.align_right`)}
            />
          )}
          {hasModule("align_justify") && (
            <RichTextEditorTextAlign
              alignment="justify"
              editor={editor}
              label={trans(`rich-text-editor.align_justify`)}
            />
          )}
        </>
      )}

      {/* Lists */}
      {hasModules(["bullet_list", "ordered_list"]) && (
        <>
          <Separator orientation="vertical" />

          {hasModule("bullet_list") && (
            <RichTextEditorBulletList
              editor={editor}
              label={trans("rich-text-editor.bullet_list")}
            />
          )}
          {hasModule("ordered_list") && (
            <RichTextEditorOrderedList
              editor={editor}
              label={trans("rich-text-editor.ordered_list")}
            />
          )}
        </>
      )}

      {/* Controls */}
      {hasModules(["undo", "redo"]) && (
        <>
          <Separator orientation="vertical" />

          {hasModule("undo") && (
            <RichTextEditorUndo editor={editor} label={trans("rich-text-editor.redo")} />
          )}
          {hasModule("redo") && (
            <RichTextEditorRedo editor={editor} label={trans("rich-text-editor.undo")} />
          )}
        </>
      )}
    </div>
  );
}

export default RichTextEditorToolbar;
