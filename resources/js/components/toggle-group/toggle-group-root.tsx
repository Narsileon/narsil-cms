import { ToggleGroup } from "@base-ui/react/toggle-group";
import { toggleRootVariants } from "@narsil-cms/components/toggle";
import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import { ToggleGroupContext } from "./toggle-group-context";

type ToggleGroupRootProps = ToggleGroup.Props &
  VariantProps<typeof toggleRootVariants> & {
    orientation?: "horizontal" | "vertical";
    spacing?: number;
  };

function ToggleGroupRoot({
  children,
  className,
  orientation = "horizontal",
  size,
  spacing = 0,
  variant,
  ...props
}: ToggleGroupRootProps) {
  return (
    <ToggleGroup
      data-slot="toggle-group-root"
      data-variant={variant}
      data-size={size}
      data-spacing={spacing}
      data-orientation={orientation}
      style={{ "--gap": spacing } as React.CSSProperties}
      className={cn(
        "group/toggle-group",
        "flex w-fit flex-row items-center rounded-lg",
        "gap-[--spacing(var(--gap))]",
        "data-[orientation=vertical]:flex-col data-[orientation=vertical]:items-stretch",
        "data-[size=sm]:rounded-[min(var(--radius-md),10px)]",
        className,
      )}
      {...props}
    >
      <ToggleGroupContext.Provider
        value={{ orientation: orientation, spacing: spacing, size: size, variant: variant }}
      >
        {children}
      </ToggleGroupContext.Provider>
    </ToggleGroup>
  );
}

export default ToggleGroupRoot;
