import { cva } from "class-variance-authority";

import { cn } from "@narsil-cms/lib/utils";

const buttonRootVariants = cva(
  cn(
    "inline-flex shrink-0 cursor-pointer items-center justify-center gap-2 rounded-md font-medium whitespace-nowrap transition-all duration-300 outline-none",
    "aria-invalid:border-destructive aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40",
    "disabled:pointer-events-none disabled:opacity-50",
    "focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/50",
    "[&_svg]:pointer-events-none [&_svg]:shrink-0",
  ),
  {
    variants: {
      variant: {
        primary: cn(
          "text-primary-foreground shadow-xs",
          "bg-primary hover:bg-primary/85",
        ),
        destructive: cn(
          "text-destructive-foreground shadow-xs",
          "bg-destructive hover:bg-destructive/85",
          "focus-visible:ring-destructive/50",
        ),
        outline: cn(
          "border border-input shadow-xs",
          "bg-background hover:bg-accent hover:text-accent-foreground",
        ),
        secondary: cn(
          "text-secondary-foreground shadow-xs",
          "bg-secondary/85 hover:bg-secondary",
        ),
        ghost: cn("hover:bg-accent hover:text-accent-foreground"),
        link: cn("text-primary underline-offset-4", "hover:underline"),
      },
      size: {
        default: "h-9 px-3 py-2 has-[>svg]:px-2",
        sm: "h-8 gap-1.5 px-3 has-[>svg]:px-2",
        lg: "h-10 px-6 has-[>svg]:px-2",
        icon: "size-9",
        link: "",
      },
    },
    defaultVariants: {
      variant: "primary",
      size: "default",
    },
  },
);

export default buttonRootVariants;
