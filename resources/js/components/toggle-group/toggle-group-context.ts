import { toggleRootVariants } from "@narsil-cms/components/toggle";
import { type VariantProps } from "class-variance-authority";
import { createContext, useContext } from "react";

export const ToggleGroupContext = createContext<VariantProps<typeof toggleRootVariants>>({
  size: "default",
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
