import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function TableCaption({ className, ...props }: ComponentProps<"caption">) {
  return (
    <caption
      data-slot="table-caption"
      className={cn("mt-4 text-muted-foreground", className)}
      {...props}
    />
  );
}
export default TableCaption;
