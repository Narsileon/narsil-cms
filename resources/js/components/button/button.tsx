import { Button as ButtonPrimitive } from "@base-ui/react";
import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import buttonVariants from "./button-variants";

type ButtonProps = ButtonPrimitive.Props & VariantProps<typeof buttonVariants>;

function Button({
  className,
  size = "default",
  type = "button",
  variant = "primary",
  ...props
}: ButtonProps) {
  return (
    <ButtonPrimitive
      data-slot="button"
      className={cn(buttonVariants({ size: size, variant: variant }))}
      type={type}
      {...props}
    />
  );
}

export default Button;
