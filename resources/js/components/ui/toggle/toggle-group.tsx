import { cn } from "@/components";
import { createContext, useContext } from "react";
import { ToggleGroup as ToggleGroupPrimitive } from "radix-ui";
import { toggleVariants } from "./toggle";
import { VariantProps } from "class-variance-authority";

const ToggleGroupContext = createContext<VariantProps<typeof toggleVariants>>({
  size: "default",
  variant: "default",
});

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

export function useToggleGroup() {
  const context = useContext(ToggleGroupContext);

  if (!context) {
    throw new Error("useToggleGroup must be used within a ToggleGroup");
  }

  return context;
}

export default ToggleGroup;
