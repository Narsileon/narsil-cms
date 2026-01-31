import { toggleRootVariants } from "@narsil-cms/components/toggle";
import { type VariantProps } from "class-variance-authority";
import { createContext, useContext } from "react";

type ToggleGroupContextProps = VariantProps<typeof toggleRootVariants> & {
  orientation: "horizontal" | "vertical";
  spacing?: number;
};

export const ToggleGroupContext = createContext<ToggleGroupContextProps>({
  orientation: "horizontal",
  size: "default",
  spacing: 0,
  variant: "default",
});

function useToggleGroup() {
  const context = useContext(ToggleGroupContext);

  if (!context) {
    throw new Error("useToggleGroup must be used within a ToggleGroup");
  }

  return context;
}

export default useToggleGroup;
