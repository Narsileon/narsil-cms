import { type ComponentProps } from "react";

import {
  RichTextEditorContent,
  RichTextEditorProvider,
  RichTextEditorRoot,
  RichTextEditorToolbar,
} from "@narsil-cms/components/rich-text-editor";

type RichTextEditorProps = ComponentProps<typeof RichTextEditorProvider> &
  Pick<ComponentProps<typeof RichTextEditorContent>, "id"> &
  Pick<ComponentProps<typeof RichTextEditorToolbar>, "modules"> & {
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
