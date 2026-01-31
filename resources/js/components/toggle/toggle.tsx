import { Toggle as TogglePrimitive } from "@base-ui/react/toggle";
import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import { toggleVariants } from ".";

type ToggleRootProps = TogglePrimitive.Props & VariantProps<typeof toggleVariants>;

function Toggle({ className, variant, size, ...props }: ToggleRootProps) {
  return (
    <TogglePrimitive
      data-slot="toggle"
      className={cn(
        toggleVariants({
          size: size,
          variant: variant,
        }),
        className,
      )}
      {...props}
    />
  );
}

export default Toggle;
