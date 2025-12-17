import {
  RichTextEditorContent,
  RichTextEditorProvider,
  RichTextEditorRoot,
  RichTextEditorToolbar,
} from "@narsil-cms/components/rich-text-editor";
import { type ComponentProps } from "react";

type RichTextEditorProps = ComponentProps<typeof RichTextEditorProvider> &
  Pick<ComponentProps<typeof RichTextEditorContent>, "id" | "required"> &
  Pick<ComponentProps<typeof RichTextEditorToolbar>, "modules"> & {
    toolbar?: boolean;
  };

function RichTextEditor({
  className,
  id,
  modules,
  required,
  toolbar = true,
  ...props
}: RichTextEditorProps) {
  return (
    <RichTextEditorRoot className={className}>
      <RichTextEditorProvider {...props}>
        {toolbar ? <RichTextEditorToolbar modules={modules} /> : null}
        <RichTextEditorContent id={id} required={required} />
      </RichTextEditorProvider>
    </RichTextEditorRoot>
  );
}

export default RichTextEditor;
