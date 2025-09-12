import { type VariantProps } from "class-variance-authority";
import { Toggle as TogglePrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

import { toggleVariants } from ".";

type ToggleRootProps = React.ComponentProps<typeof TogglePrimitive.Root> &
  VariantProps<typeof toggleVariants> & {};

function ToggleRoot({ className, variant, size, ...props }: ToggleRootProps) {
  return (
    <TogglePrimitive.Root
      data-slot="toggle"
      className={cn(
        toggleVariants({
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
