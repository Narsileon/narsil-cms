import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";

const separatorRootVariants = cva(cn("bg-border"), {
  variants: {
    variant: {
      default: cn(
        "shrink-0",
        "data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full",
        "data-[orientation=vertical]:h-full data-[orientation=vertical]:w-px",
      ),
      menu: cn("pointer-events-none -mx-1 my-1 h-px"),
    },
  },
  defaultVariants: {
    variant: "default",
  },
});

export default separatorRootVariants;
