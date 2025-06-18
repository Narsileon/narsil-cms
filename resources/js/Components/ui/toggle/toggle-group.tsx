import { cn } from "@/Components";
import { createContext, useContext } from "react";
import { Root } from "@radix-ui/react-toggle-group";
import { toggleVariants } from "./toggle";
import { VariantProps } from "class-variance-authority";

const ToggleGroupContext = createContext<VariantProps<typeof toggleVariants>>({
  size: "default",
  variant: "default",
});

export type ToggleGroupProps = React.ComponentProps<typeof Root> &
  VariantProps<typeof toggleVariants> & {};

function ToggleGroup({
  children,
  className,
  size,
  variant,
  ...props
}: ToggleGroupProps) {
  return (
    <Root
      className={cn(
        "group/toggle-group flex w-fit items-center rounded-md",
        "data-[variant=outline]:shadow-xs",
        className,
      )}
      data-size={size}
      data-slot="toggle-group"
      data-variant={variant}
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
    </Root>
  );
}

export function useToggleGroupContext() {
  const context = useContext(ToggleGroupContext);

  if (!context) {
    throw new Error(
      "useToggleGroupContext must be used within a <ToggleGroup />",
    );
  }

  return context;
}

export default ToggleGroup;
