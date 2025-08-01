import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";
import { Slot as SlotPrimitive } from "radix-ui";
import type { VariantProps } from "class-variance-authority";

export const buttonVariants = cva(
  cn(
    "inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all shrink-0 outline-none",
    "aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive",
    "disabled:pointer-events-none disabled:opacity-50",
    "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]",
    "[&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-6 [&_svg]:shrink-0",
  ),
  {
    variants: {
      variant: {
        default: cn(
          "bg-primary text-primary-foreground shadow-xs",
          "hover:bg-primary/90",
        ),
        destructive: cn(
          "bg-destructive text-white shadow-xs",
          "dark:bg-destructive/60 dark:focus-visible:ring-destructive/40",
          "hover:bg-destructive/90",
          "focus-visible:ring-destructive/20",
        ),
        outline: cn(
          "border bg-background shadow-xs",
          "dark:bg-input/30 dark:border-input dark:hover:bg-input/50",
          "hover:bg-accent hover:text-accent-foreground",
        ),
        secondary: cn(
          "bg-secondary text-secondary-foreground shadow-xs",
          "hover:bg-secondary/80",
        ),
        ghost: cn(
          "dark:hover:bg-accent",
          "hover:bg-accent hover:text-accent-foreground",
        ),
        link: cn("text-primary underline-offset-4", "hover:underline"),
      },
      size: {
        default: "h-9 px-4 py-2 has-[>svg]:px-2",
        sm: "h-8 gap-1.5 px-3 has-[>svg]:px-2.5",
        lg: "h-10 px-6 has-[>svg]:px-4",
        icon: "size-9",
      },
    },
    defaultVariants: {
      variant: "default",
      size: "default",
    },
  },
);

type ButtonProps = React.ComponentProps<"button"> &
  VariantProps<typeof buttonVariants> & {
    asChild?: boolean;
  };

function Button({
  asChild = false,
  className,
  size,
  variant,
  ...props
}: ButtonProps) {
  const Comp = asChild ? SlotPrimitive.Slot : "button";

  return (
    <Comp
      data-slot="button"
      className={cn(
        buttonVariants({
          className: className,
          size: size,
          variant: variant,
        }),
      )}
      {...props}
    />
  );
}

export default Button;
