import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Select as SelectPrimitive } from "radix-ui";

type SelectLabelProps = React.ComponentProps<typeof SelectPrimitive.Label> & {};

function SelectLabel({ className, ...props }: SelectLabelProps) {
  return (
    <SelectPrimitive.Label
      data-slot="select-label"
      className={cn("text-muted-foreground px-2 py-1.5 text-xs", className)}
      {...props}
    />
  );
}

export default SelectLabel;
