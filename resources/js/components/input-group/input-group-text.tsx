import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function InputGroupText({ className, ...props }: ComponentProps<"span">) {
  return (
    <span
      data-slot="input-group-text"
      className={cn(
        "flex items-center gap-2 text-sm text-muted-foreground",
        "[&_svg]:pointer-events-none",
        "[&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    />
  );
}

export default InputGroupText;
