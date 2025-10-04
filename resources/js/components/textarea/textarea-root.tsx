import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type TextareaRootProps = ComponentProps<"textarea"> & {};

function TextareaRoot({ className, ...props }: TextareaRootProps) {
  return (
    <textarea
      data-slot="textarea-root"
      className={cn(
        "field-sizing-content border-input placeholder:text-muted-foreground flex min-h-16 w-full rounded-md border bg-transparent px-3 py-2 shadow-sm outline-none transition-[color,box-shadow]",
        "aria-invalid:border-destructive aria-invalid:ring-destructive/20",
        "dark:bg-input/30 dark:aria-invalid:ring-destructive/40",
        "disabled:cursor-not-allowed disabled:opacity-50",
        "focus-visible:border-shine focus-within:border-shine",
        className,
      )}
      {...props}
    />
  );
}

export default TextareaRoot;
