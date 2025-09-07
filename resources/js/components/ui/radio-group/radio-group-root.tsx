import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { RadioGroup as RadioGroupPrimitive } from "radix-ui";

type RadioGroupRootProps = React.ComponentProps<
  typeof RadioGroupPrimitive.Root
> & {};

function RadioGroupRoot({ className, ...props }: RadioGroupRootProps) {
  return (
    <RadioGroupPrimitive.Root
      data-slot="radio-group-root"
      className={cn("grid gap-3", className)}
      {...props}
    />
  );
}

export default RadioGroupRoot;
