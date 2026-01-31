import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function TextareaRoot({ className, ...props }: ComponentProps<"textarea">) {
  return (
    <textarea
      data-slot="textarea-root"
      className={cn(
        "flex field-sizing-content min-h-16 w-full rounded-md border border-input bg-transparent px-3 py-2 shadow-sm transition-[color,box-shadow] outline-none placeholder:text-muted-foreground",
        "aria-invalid:border-destructive aria-invalid:ring-destructive/20",
        "dark:bg-input/30 dark:aria-invalid:ring-destructive/40",
        "disabled:cursor-not-allowed disabled:opacity-50",
        "focus-within:border-shine focus-visible:border-shine",
        className,
      )}
      {...props}
    />
  );
}

export default TextareaRoot;
