import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";

const dialogContentVariants = cva(
  cn(
    "@container/dialog-popup",
    "fixed z-50 flex flex-col overflow-hidden bg-background transition ease-in-out",
    "data-closed:animate-out data-closed:duration-300",
    "data-open:animate-in data-open:duration-200",
  ),
  {
    variants: {
      variant: {
        default: cn(
          "top-[50%] left-[50%] max-h-3/4 translate-x-[-50%] translate-y-[-50%] border md:max-h-1/2",
          "w-full max-w-[calc(100%-2rem)] rounded-xl shadow-lg md:max-w-lg",
          "data-closed:fade-out-0 data-closed:zoom-out-95",
          "data-open:fade-in-0 data-open:zoom-in-95",
        ),
        bottom: cn(
          "inset-x-0 bottom-0 h-auto border-t",
          "data-closed:slide-out-to-bottom",
          "data-open:slide-in-from-bottom",
        ),
        left: cn(
          "inset-y-0 left-0 h-full min-w-3/4 border-r sm:max-w-sm",
          "data-closed:slide-out-to-left",
          "data-open:slide-in-from-left",
        ),
        right: cn(
          "inset-y-0 right-0 h-full min-w-3/4 border-l sm:max-w-sm",
          "data-closed:slide-out-to-right",
          "data-open:slide-in-from-right",
        ),
        top: cn(
          "inset-x-0 top-0 h-auto border-b",
          "data-closed:slide-out-to-top",
          "data-open:slide-in-from-top",
        ),
      },
    },
    defaultVariants: {
      variant: "default",
    },
  },
);

export default dialogContentVariants;
