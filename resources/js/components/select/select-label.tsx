import { Select } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type SelectLabelProps = ComponentProps<typeof Select.Label> & {};

function SelectLabel({ className, ...props }: SelectLabelProps) {
  return (
    <Select.Label
      data-slot="select-label"
      className={cn("px-2 py-1.5 text-xs text-muted-foreground", className)}
      {...props}
    />
  );
}

export default SelectLabel;
