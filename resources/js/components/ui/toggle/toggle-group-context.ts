import * as React from "react";
import { toggleVariants } from "./toggle";
import type { VariantProps } from "class-variance-authority";

export const ToggleGroupContext = React.createContext<
  VariantProps<typeof toggleVariants>
>({
  size: "default",
  variant: "default",
});

function useToggleGroup() {
  const context = React.useContext(ToggleGroupContext);

  if (!context) {
    throw new Error("useToggleGroup must be used within a ToggleGroup");
  }

  return context;
}

export default useToggleGroup;
