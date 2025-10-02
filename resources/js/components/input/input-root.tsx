import { type VariantProps } from "class-variance-authority";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

import inputWrapperVariants from "./input-root-variants";

type InputRootProps = ComponentProps<"div"> &
  VariantProps<typeof inputWrapperVariants> & {};

function InputRoot({ className, variant, ...props }: InputRootProps) {
  return (
    <div
      data-slot="input-root"
      className={cn(
        inputWrapperVariants({
          variant: variant,
          className: className,
        }),
      )}
      {...props}
    />
  );
}

export default InputRoot;
