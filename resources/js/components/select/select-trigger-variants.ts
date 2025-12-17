import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";

const selectTriggerVariants = cva(
  cn(
    "flex w-fit cursor-pointer items-center justify-between rounded-md bg-transparent whitespace-nowrap transition-[color,box-shadow] outline-none",
    "disabled:cursor-not-allowed disabled:opacity-50",

    "*:data-[slot=select-value]:line-clamp-1 *:data-[slot=select-value]:flex *:data-[slot=select-value]:items-center",
    "[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='text-'])]:text-muted-foreground",
  ),
  {
    variants: {
      variant: {
        default: cn(
          "border border-input p-2 shadow-sm",
          "dark:bg-input/30 dark:hover:bg-input/50",
          "aria-invalid:border-destructive aria-invalid:ring-destructive/20",
          "data-placeholder:text-muted-foreground",
          "focus-visible:border-shine",
          "data-[state=open]:border-shine",
        ),
        secondary: cn(
          "border border-secondary bg-secondary/80 p-2 text-secondary-foreground",
          "focus-visible:bg-secondary",
          "focus-visible:border-shine",
          "hover:bg-secondary",
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
