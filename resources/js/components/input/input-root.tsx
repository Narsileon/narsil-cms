import { type VariantProps } from "class-variance-authority";

import { cn } from "@narsil-cms/lib/utils";

import inputWrapperVariants from "./input-root-variants";

type InputRootProps = React.ComponentProps<"div"> &
  VariantProps<typeof inputWrapperVariants> & {};

function InputRoot({ className, variant, ...props }: InputRootProps) {
  return (
    <div
      data-slot="input-root"
      className={cn(
        inputWrapperVariants({
          className: className,
          variant: variant,
        }),
      )}
      {...props}
    />
  );
}

export default InputRoot;
