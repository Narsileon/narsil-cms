import { cva, type VariantProps } from "class-variance-authority";
import { Slot } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

const badgeVariants = cva(
  cn(
    "inline-flex w-fit shrink-0 items-center justify-center overflow-hidden rounded-xs border px-2 py-0.5 text-xs font-medium whitespace-nowrap transition-[color,box-shadow]",
    "aria-invalid:border-destructive aria-invalid:ring-destructive/20",
    "dark:aria-invalid:ring-destructive/50",
    "focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/50",
    "gap-1 [&>svg]:pointer-events-none [&>svg]:size-3",
  ),
  {
    variants: {
      variant: {
        default: cn(
          "border-transparent bg-primary text-primary-foreground",
          "[a&]:hover:bg-primary/90",
        ),
        secondary: cn(
          "border-transparent bg-secondary text-secondary-foreground",
          "[a&]:hover:bg-secondary/90",
        ),
        destructive: cn(
          "border-transparent bg-destructive text-white",
          "dark:bg-destructive/60 dark:focus-visible:ring-destructive/40",
          "focus-visible:ring-destructive/20",
          "[a&]:hover:bg-destructive/90",
        ),
        outline: cn(
          "text-foreground",
          "[a&]:hover:bg-accent [a&]:hover:text-accent-foreground",
        ),
      },
    },
    defaultVariants: {
      variant: "default",
    },
  },
);

type BadgeProps = React.ComponentProps<"span"> &
  VariantProps<typeof badgeVariants> & { asChild?: boolean };

function Badge({ asChild = false, className, variant, ...props }: BadgeProps) {
  const Comp = asChild ? Slot.Root : "span";

  return (
    <Comp
      data-slot="badge"
      className={cn(badgeVariants({ variant }), className)}
      {...props}
    />
  );
}

export default Badge;
