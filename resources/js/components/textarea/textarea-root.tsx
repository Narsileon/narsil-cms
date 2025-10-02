import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type TextareaRootProps = ComponentProps<"textarea"> & {};

function TextareaRoot({ className, ...props }: TextareaRootProps) {
  return (
    <textarea
      data-slot="textarea-root"
      className={cn(
        "field-sizing-content border-input shadow-xs placeholder:text-muted-foreground flex min-h-16 w-full rounded-md border bg-transparent px-3 py-2 outline-none transition-[color,box-shadow]",
        "aria-invalid:border-destructive aria-invalid:ring-destructive/20",
        "dark:bg-input/30 dark:aria-invalid:ring-destructive/40",
        "disabled:cursor-not-allowed disabled:opacity-50",
        "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-2",
        className,
      )}
      {...props}
    />
  );
}

export default TextareaRoot;
