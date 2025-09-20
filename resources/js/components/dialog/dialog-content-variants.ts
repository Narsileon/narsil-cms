import { cva } from "class-variance-authority";

import { cn } from "@narsil-cms/lib/utils";

const dialogContentVariants = cva(
  cn(
    "@container/dialog-content",
    "fixed z-50 flex flex-col overflow-hidden border bg-background transition ease-in-out",
    "data-[state=closed]:animate-out data-[state=closed]:duration-300",
    "data-[state=open]:animate-in data-[state=open]:duration-300",
  ),
  {
    variants: {
      variant: {
        default: cn(
          "top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%]",
          "w-full max-w-[calc(100%-2rem)] rounded-xl shadow-lg md:max-w-lg",
          "data-[state=closed]:fade-out-0 data-[state=closed]:zoom-out-95",
          "data-[state=open]:fade-in-0 data-[state=open]:zoom-in-95",
        ),
        bottom: cn(
          "inset-x-0 bottom-0 h-auto border-t",
          "data-[state=closed]:slide-out-to-bottom",
          "data-[state=open]:slide-in-from-bottom",
        ),
        left: cn(
          "inset-y-0 left-0 h-full w-3/4 border-r sm:max-w-sm",
          "data-[state=closed]:slide-out-to-left",
          "data-[state=open]:slide-in-from-left",
        ),
        right: cn(
          "inset-y-0 right-0 h-full w-3/4 border-l sm:max-w-sm",
          "data-[state=closed]:slide-out-to-right",
          "data-[state=open]:slide-in-from-right",
        ),
        top: cn(
          "inset-x-0 top-0 h-auto border-b",
          "data-[state=closed]:slide-out-to-top",
          "data-[state=open]:slide-in-from-top",
        ),
      },
    },
    defaultVariants: {
      variant: "default",
    },
  },
);

export default dialogContentVariants;
