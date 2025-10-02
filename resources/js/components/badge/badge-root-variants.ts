import { cva } from "class-variance-authority";

import { cn } from "@narsil-cms/lib/utils";

const badgeRootVariants = cva(
  cn(
    "rounded-xs inline-flex h-7 w-fit shrink-0 items-center justify-center gap-2 overflow-hidden whitespace-nowrap border px-2 py-0.5 text-xs font-medium transition-[color,box-shadow]",
    "aria-invalid:border-destructive aria-invalid:ring-destructive/20",
    "dark:aria-invalid:ring-destructive/50",
    "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-2",
    "[&>svg]:pointer-events-none [&>svg]:size-3",
  ),
  {
    variants: {
      variant: {
        default: cn(
          "bg-primary text-primary-foreground border-transparent",
          "[a&]:hover:bg-primary/90 [&>svg]:size-3",
        ),
        secondary: cn(
          "bg-secondary text-secondary-foreground border-transparent",
          "[a&]:hover:bg-secondary/90",
        ),
        destructive: cn(
          "bg-destructive border-transparent text-white",
          "dark:bg-destructive/60 dark:focus-visible:ring-destructive/40",
          "focus-visible:ring-destructive/20",
          "[a&]:hover:bg-destructive/90",
        ),
        outline: cn(
          "text-foreground",
          "[a&]:hover:bg-accent [a&]:hover:text-accent-foreground",
        ),
      },
    },
    defaultVariants: {
      variant: "default",
    },
  },
);

export default badgeRootVariants;
