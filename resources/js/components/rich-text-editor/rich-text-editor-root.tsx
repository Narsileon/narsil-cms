import { cn } from "@narsil-cms/lib/utils";

import React from "react";

type RichTextEditorRootProps = React.ComponentProps<"div"> & {};

function RichTextEditorRoot({ className, ...props }: RichTextEditorRootProps) {
  return (
    <div
      className={cn("border-color flex flex-col rounded-md border", className)}
      {...props}
    />
  );
}

export default RichTextEditorRoot;
