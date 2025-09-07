import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { ToggleGroup as ToggleGroupPrimitive } from "radix-ui";
import { ToggleGroupContext } from "./toggle-group-context";
import { toggleVariants } from "@narsil-cms/components/toggle";
import type { VariantProps } from "class-variance-authority";

type ToggleGroupRootProps = React.ComponentProps<
  typeof ToggleGroupPrimitive.Root
> &
  VariantProps<typeof toggleVariants> & {};

function ToggleGroupRoot({
  children,
  className,
  size,
  variant,
  ...props
}: ToggleGroupRootProps) {
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

export default ToggleGroupRoot;
