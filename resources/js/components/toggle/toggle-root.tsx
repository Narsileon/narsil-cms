import { type VariantProps } from "class-variance-authority";
import { Toggle } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

import { toggleRootVariants } from ".";

type ToggleRootProps = ComponentProps<typeof Toggle.Root> &
  VariantProps<typeof toggleRootVariants> & {};

function ToggleRoot({ className, variant, size, ...props }: ToggleRootProps) {
  return (
    <Toggle.Root
      data-slot="toggle"
      className={cn(
        toggleRootVariants({
          className: className,
          size: size,
          variant: variant,
        }),
      )}
      {...props}
    />
  );
}

export default ToggleRoot;
