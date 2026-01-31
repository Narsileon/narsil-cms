import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function RichTextEditorRoot({ className, ...props }: ComponentProps<"div">) {
  return (
    <div className={cn("border-color flex flex-col rounded-md border", className)} {...props} />
  );
}

export default RichTextEditorRoot;
