import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type TableCaptionProps = ComponentProps<"caption">;

function TableCaption({ className, ...props }: TableCaptionProps) {
  return (
    <caption
      data-slot="table-caption"
      className={cn("mt-4 text-muted-foreground", className)}
      {...props}
    />
  );
}
export default TableCaption;
