import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";

const selectTriggerVariants = cva(
  cn(
    "flex w-fit cursor-pointer items-center justify-between whitespace-nowrap rounded-md bg-transparent shadow-sm outline-none transition-[color,box-shadow]",
    "disabled:cursor-not-allowed disabled:opacity-50",
    "focus-visible:border-shine",
    "*:data-[slot=select-value]:line-clamp-1 *:data-[slot=select-value]:flex *:data-[slot=select-value]:items-center",
    "[&_svg:not([class*='text-'])]:text-muted-foreground [&_svg]:pointer-events-none [&_svg]:shrink-0",
  ),
  {
    variants: {
      variant: {
        default: cn(
          "border-input border p-2",
          "dark:bg-input/30 dark:hover:bg-input/50",
          "aria-invalid:border-destructive aria-invalid:ring-destructive/20",
          "data-[placeholder]:text-muted-foreground",
          "data-[state=open]:border-shine",
        ),
        inline: cn(""),
      },
      size: {
        default: "h-9 gap-2",
        sm: "h-7 gap-1 [&_svg]:size-4",
      },
    },
    defaultVariants: {
      variant: "default",
      size: "default",
    },
  },
);

export default selectTriggerVariants;
