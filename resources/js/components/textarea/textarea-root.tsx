import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type TextareaRootProps = ComponentProps<"textarea"> & {};

function TextareaRoot({ className, ...props }: TextareaRootProps) {
  return (
    <textarea
      data-slot="textarea-root"
      className={cn(
        "flex field-sizing-content min-h-16 w-full rounded-md border border-input bg-transparent px-3 py-2 shadow-xs transition-[color,box-shadow] outline-none placeholder:text-muted-foreground",
        "aria-invalid:border-destructive aria-invalid:ring-destructive/20",
        "dark:bg-input/30 dark:aria-invalid:ring-destructive/40",
        "disabled:cursor-not-allowed disabled:opacity-50",
        "focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/50",
        className,
      )}
      {...props}
    />
  );
}

export default TextareaRoot;
