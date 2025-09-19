import { type VariantProps } from "class-variance-authority";
import { Slot } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

import buttonRootVariants from "./button-root-variants";

type ButtonRootProps = React.ComponentProps<"button"> &
  VariantProps<typeof buttonRootVariants> & {
    asChild?: boolean;
  };

function ButtonRoot({
  asChild = false,
  className,
  size,
  type = "button",
  variant = "default",
  ...props
}: ButtonRootProps) {
  const Comp = asChild ? Slot.Root : "button";

  return (
    <Comp
      data-slot="button"
      className={cn(
        buttonRootVariants({
          className: className,
          size: size,
          variant: variant,
        }),
      )}
      type={type}
      {...props}
    />
  );
}

export default ButtonRoot;
