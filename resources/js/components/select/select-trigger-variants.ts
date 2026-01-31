import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";

const selectTriggerVariants = cva(
  cn(
    "flex w-fit items-center justify-between gap-1.5 rounded-lg bg-transparent text-sm whitespace-nowrap transition-colors outline-none select-none",
    "[&_svg:not([class*='size-'])]:size-4",
    "[&_svg]:pointer-events-none [&_svg]:shrink-0",
    "*:data-[slot=select-value]:line-clamp-1 *:data-[slot=select-value]:flex *:data-[slot=select-value]:items-center *:data-[slot=select-value]:gap-1.5",
    "aria-invalid:border-destructive aria-invalid:ring-[3px] aria-invalid:ring-destructive/20",
    "dark:aria-invalid:border-destructive/50 dark:aria-invalid:ring-destructive/40",
    "dark:hover:bg-input/50",
    "data-[size=default]:h-8 data-[size=sm]:h-7",
    "data-[size=sm]:rounded-[min(var(--radius-md),10px)]",
    "data-placeholder:text-muted-foreground",
    "disabled:cursor-not-allowed disabled:opacity-50",
  ),
  {
    variants: {
      variant: {
        default: cn(
          "border border-input p-2 shadow-sm",
          "dark:bg-input/30 dark:hover:bg-input/50",
          "focus-visible:border-shine",
          "data-[state=open]:border-shine",
        ),
        secondary: cn(
          "border border-secondary bg-secondary/80 p-2 text-secondary-foreground",
          "focus-visible:border-shine",
          "hover:bg-secondary",
          "data-[state=open]:border-shine",
        ),
        inline: cn(
          "px-1 focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50",
        ),
      },
    },
    defaultVariants: {
      variant: "default",
    },
  },
);

export default selectTriggerVariants;
