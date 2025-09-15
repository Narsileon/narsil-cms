import {
  RichTextEditorContent,
  RichTextEditorProvider,
  RichTextEditorRoot,
  RichTextEditorToolbar,
} from "@narsil-cms/components/rich-text-editor";
import React from "react";

type RichTextEditorProps = React.ComponentProps<typeof RichTextEditorProvider> &
  Pick<React.ComponentProps<typeof RichTextEditorContent>, "id"> &
  Pick<React.ComponentProps<typeof RichTextEditorToolbar>, "modules"> & {
    toolbar?: boolean;
  };

function RichTextEditor({
  className,
  id,
  modules,
  toolbar = true,
  ...props
}: RichTextEditorProps) {
  return (
    <RichTextEditorRoot className={className}>
      <RichTextEditorProvider {...props}>
        {toolbar ? <RichTextEditorToolbar modules={modules} /> : null}
        <RichTextEditorContent id={id} />
      </RichTextEditorProvider>
    </RichTextEditorRoot>
  );
}

export default RichTextEditor;
