import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import { type ComponentProps } from "react";
import inputWrapperVariants from "./input-root-variants";

type InputRootProps = ComponentProps<"div"> &
  VariantProps<typeof inputWrapperVariants> & {
    readOnly?: boolean;
  };

function InputRoot({ className, readOnly, variant, ...props }: InputRootProps) {
  return (
    <div
      data-slot="input-root"
      className={cn(
        inputWrapperVariants({
          variant: variant,
          className: className,
        }),
      )}
      aria-readonly={readOnly}
      {...props}
    />
  );
}

export default InputRoot;
