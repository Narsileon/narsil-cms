import { toggleRootVariants } from "@narsil-cms/components/toggle";
import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import { ToggleGroup } from "radix-ui";
import { type ComponentProps } from "react";
import { ToggleGroupContext } from "./toggle-group-context";

type ToggleGroupRootProps = ComponentProps<typeof ToggleGroup.Root> &
  VariantProps<typeof toggleRootVariants>;

function ToggleGroupRoot({
  children,
  className,
  orientation = "horizontal",
  size,
  variant,
  ...props
}: ToggleGroupRootProps) {
  return (
    <ToggleGroup.Root
      data-slot="toggle-group"
      data-orientation={orientation}
      data-size={size}
      data-variant={variant}
      className={cn(
        "group/toggle-group flex w-fit items-center rounded-md",
        "data-[variant=outline]:shadow-sm",
        orientation === "vertical" && "w-full flex-col gap-1",
        orientation === "horizontal" && "w-fit flex-row",
        className,
      )}
      {...props}
    >
      <ToggleGroupContext.Provider
        value={{
          orientation: orientation,
          size: size,
          variant: variant,
        }}
      >
        {children}
      </ToggleGroupContext.Provider>
    </ToggleGroup.Root>
  );
}

export default ToggleGroupRoot;
