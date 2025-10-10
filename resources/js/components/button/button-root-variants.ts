import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";

const buttonRootVariants = cva(
  cn(
    "inline-flex shrink-0 cursor-pointer items-center justify-center gap-2 whitespace-nowrap rounded-md font-medium outline-none transition-all duration-300",
    "aria-invalid:border-destructive aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40",
    "disabled:pointer-events-none disabled:opacity-50",
    "[&_svg]:pointer-events-none [&_svg]:shrink-0",
  ),
  {
    variants: {
      variant: {
        primary: cn(
          "bg-primary/80 text-primary-foreground",
          "focus-visible:bg-primary",
          "hover:bg-primary",
          "[&_svg]:text-primary-foreground",
        ),
        destructive: cn(
          "bg-destructive/80 text-destructive-foreground",
          "focus-visible:bg-destructive",
          "hover:bg-destructive",
        ),
        outline: cn(
          "border-input bg-background border shadow-sm",
          "focus-visible:border-shine",
          "hover:bg-accent hover:text-accent-foreground",
        ),
        secondary: cn(
          "bg-secondary/80 text-secondary-foreground",
          "focus-visible:bg-secondary",
          "hover:bg-secondary",
        ),
        ghost: cn(
          "focus-visible:bg-accent focus-visible:text-accent-foreground",
          "hover:bg-accent hover:text-accent-foreground",
        ),
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
