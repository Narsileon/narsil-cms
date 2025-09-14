import { cva } from "class-variance-authority";

import { cn } from "@narsil-cms/lib/utils";

const containerRootVariants = cva(
  cn("mx-auto h-[inherit] min-h-[inherit] w-[inherit] max-w-7xl gap-3 px-3"),
  {
    variants: {
      variant: {
        default: "",
        centered: "flex flex-col items-center justify-center",
      },
    },
    defaultVariants: {
      variant: "default",
    },
  },
);

export default containerRootVariants;
