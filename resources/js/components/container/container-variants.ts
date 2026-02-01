import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";

const containerVariants = cva(cn("mx-auto flex flex-col items-center gap-4 px-4"), {
  variants: {
    paddingBottom: {
      none: "",
      sm: "pb-4 md:pb-6 lg:pb-8 xl:pb-10",
      md: "pb-8 md:pb-12 lg:pb-16 xl:pb-20",
      lg: "pb-16 md:pb-24 lg:pb-32 xl:pb-40",
    },
    paddingTop: {
      none: "",
      sm: "pt-4 md:pt-6 lg:pt-8 xl:pt-10",
      md: "pt-8 md:pt-12 lg:pt-16 xl:pt-20",
      lg: "pt-16 md:pt-24 lg:pt-32 xl:pt-40",
    },
    variant: {
      sm: "w-full px-4 md:px-8 lg:max-w-5xl",
      md: "w-full px-4 md:px-8 lg:max-w-7xl",
      lg: "w-full px-4 md:px-8",
    },
  },
  defaultVariants: {
    paddingBottom: "none",
    paddingTop: "none",
    variant: "md",
  },
});

export default containerVariants;
