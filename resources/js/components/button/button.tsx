import { type VariantProps } from "class-variance-authority";
import { Slot } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

import buttonVariants from "./button-variants";
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
  const Comp = asChild ? Slot.Root : "button";

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
      type="button"
      {...props}
    />
  );
}

export default Button;
