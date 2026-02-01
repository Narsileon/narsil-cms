import { Button } from "@narsil-cms/components/button";
import { cn } from "@narsil-cms/lib/utils";
import { VariantProps } from "class-variance-authority";
import inputGroupButtonVariants from "./input-group-button-variants";

type InputGroupButtonProps = Omit<React.ComponentProps<typeof Button>, "size" | "type"> &
  VariantProps<typeof inputGroupButtonVariants> & {
    type?: "button" | "submit" | "reset";
  };

function InputGroupButton({
  className,
  size = "xs",
  type = "button",
  variant = "ghost",
  ...props
}: InputGroupButtonProps) {
  return (
    <Button
      data-slot="input-group-button"
      data-size={size}
      className={cn(inputGroupButtonVariants({ size }), className)}
      type={type}
      variant={variant}
      {...props}
    />
  );
}

export default InputGroupButton;
