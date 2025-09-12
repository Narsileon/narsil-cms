import { cn } from "@narsil-cms/lib/utils";
import { Toggle as TogglePrimitive } from "radix-ui";
import { toggleVariants } from ".";
import { type VariantProps } from "class-variance-authority";

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
