import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";
import { Slot as SlotPrimitive } from "radix-ui";
import type { VariantProps } from "class-variance-authority";

const badgeVariants = cva(
  cn(
    "inline-flex items-center justify-center rounded-md border px-2 py-0.5 w-fit shrink-0 text-xs font-medium whitespace-nowrap transition-[color,box-shadow] overflow-hidden",
    "aria-invalid:ring-destructive/20 aria-invalid:border-destructive",
    "dark:aria-invalid:ring-destructive/40",
    "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-2",
    "[&>svg]:size-3 gap-1 [&>svg]:pointer-events-none",
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
          "dark:focus-visible:ring-destructive/40 dark:bg-destructive/60",
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
  const Comp = asChild ? SlotPrimitive.Slot : "span";

  return (
    <Comp
      data-slot="badge"
      className={cn(badgeVariants({ variant }), className)}
      {...props}
    />
  );
}

export default Badge;
