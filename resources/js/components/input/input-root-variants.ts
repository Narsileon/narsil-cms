import { cva } from "class-variance-authority";

import { cn } from "@narsil-cms/lib/utils";

const inputRootVariants = cva(
  cn(
    "group/input bg-input/25 relative inline-flex h-9 w-full shrink-0 items-center justify-between gap-2 rounded-md border px-2 shadow-sm",
    "focus-within:border-shine focus-visible:border-shine transition-all duration-300",
    "aria-disabled:pointer-events-none aria-disabled:cursor-not-allowed aria-disabled:opacity-50",
    "aria-invalid:border-destructive aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40",
  ),
  {
    variants: {
      variant: {
        default: "",
        button: cn(
          "cursor-pointer",
          "hover:bg-accent hover:text-accent-foreground",
        ),
      },
    },
    defaultVariants: {
      variant: "default",
    },
  },
);

export default inputRootVariants;
