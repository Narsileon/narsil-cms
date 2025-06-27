import { cn } from "@/lib/utils";
import { ToggleGroup as ToggleGroupPrimitive } from "radix-ui";
import { ToggleGroupContext } from "./toggle-group-context";
import { toggleVariants } from "./toggle";
import type { VariantProps } from "class-variance-authority";

export type ToggleGroupProps = React.ComponentProps<
  typeof ToggleGroupPrimitive.Root
> &
  VariantProps<typeof toggleVariants> & {};

function ToggleGroup({
  children,
  className,
  size,
  variant,
  ...props
}: ToggleGroupProps) {
  return (
    <ToggleGroupPrimitive.Root
      data-slot="toggle-group"
      data-size={size}
      data-variant={variant}
      className={cn(
        "group/toggle-group flex w-fit items-center rounded-md",
        "data-[variant=outline]:shadow-xs",
        className,
      )}
      {...props}
    >
      <ToggleGroupContext.Provider
        value={{
          size: size,
          variant: variant,
        }}
      >
        {children}
      </ToggleGroupContext.Provider>
    </ToggleGroupPrimitive.Root>
  );
}

export default ToggleGroup;
