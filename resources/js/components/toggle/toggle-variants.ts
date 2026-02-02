import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";

const toggleVariants = cva(
  cn(
    "group/toggle",
    "inline-flex items-center justify-center gap-1 rounded-md text-sm font-medium whitespace-nowrap transition-all outline-none",
    "[&_svg:not([class*='size-'])]:size-4",
    "[&_svg]:pointer-events-none [&_svg]:shrink-0",
    "aria-invalid:border-destructive aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40",
    "aria-pressed:bg-muted",
    "data-[state=on]:bg-muted",
    "disabled:pointer-events-none disabled:opacity-50",
    "focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50",
    "hover:bg-muted hover:text-foreground",
  ),
  {
    variants: {
      variant: {
        default: "bg-transparent",
        outline: cn("border border-input bg-transparent", "hover:bg-muted"),
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

export default toggleVariants;
