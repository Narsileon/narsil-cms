import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";

export const buttonVariants = cva(
  cn(
    "inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all shrink-0 outline-none cursor-pointer duration-200",
    "aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive",
    "disabled:pointer-events-none disabled:opacity-50",
    "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]",
    "[&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-5 [&_svg]:shrink-0",
  ),
  {
    variants: {
      variant: {
        default: cn(
          "text-primary-foreground shadow-xs",
          "bg-primary hover:bg-primary/85",
        ),
        destructive: cn(
          "text-destructive-foreground shadow-xs",
          "bg-destructive hover:bg-destructive/85",
          "focus-visible:ring-destructive/50",
        ),
        outline: cn(
          "border-input border shadow-xs",
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
      variant: "default",
      size: "default",
    },
  },
);
