import { cva } from "class-variance-authority";

import { cn } from "@narsil-cms/lib/utils";

const toggleRootVariants = cva(
  cn(
    "inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md font-medium outline-none transition-[color,box-shadow]",
    "aria-invalid:border-destructive aria-invalid:ring-destructive/20",
    "dark:aria-invalid:ring-destructive/40",
    "dark:hover:bg-accent",
    "dark:data-[state=on]:bg-accent",
    "disabled:pointer-events-none disabled:opacity-50",
    "focus-visible:border-shine",
    "hover:bg-accent hover:text-accent-foreground",
    "data-[state=on]:bg-accent data-[state=on]:text-accent-foreground",
    "[&_svg:not([class*='size-'])]:size-4 [&_svg]:pointer-events-none [&_svg]:shrink-0",
  ),
  {
    variants: {
      variant: {
        default: "bg-transparent",
        outline: cn("border-input border bg-transparent shadow-sm"),
      },
      size: {
        default: "h-9 min-w-9 px-4",
        sm: "h-8 min-w-8 px-1.5",
        lg: "h-10 min-w-10 px-2.5",
        icon: "size-9",
      },
    },
    defaultVariants: {
      variant: "default",
      size: "default",
    },
  },
);

export default toggleRootVariants;
