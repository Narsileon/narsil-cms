import { cva } from "class-variance-authority";

import { cn } from "@narsil-cms/lib/utils";

const inputContentVariants = cva(
  cn(
    "h-full min-w-0 grow bg-transparent py-1 outline-none",
    "placeholder:text-muted-foreground",
    "selection:bg-primary selection:text-primary-foreground",
  ),
  {
    variants: {
      variant: {
        default: "",
        date: cn(
          "appearance-none [&::-webkit-calendar-picker-indicator]:hidden [&::-webkit-calendar-picker-indicator]:appearance-none",
        ),
        file: cn(
          "file:inline-flex file:h-7 file:border-0 file:bg-transparent file:file:font-medium file:text-foreground",
        ),
        image:
          "file:inline-flex file:h-7 file:border-0 file:bg-transparent file:file:font-medium file:text-foreground",
        number: cn(
          "[appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none",
        ),
      },
    },
    defaultVariants: {
      variant: "default",
    },
  },
);

export default inputContentVariants;
