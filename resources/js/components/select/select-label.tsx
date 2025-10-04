import { Select } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type SelectLabelProps = ComponentProps<typeof Select.Label>;

function SelectLabel({ className, ...props }: SelectLabelProps) {
  return (
    <Select.Label
      data-slot="select-label"
      className={cn("text-muted-foreground px-2 py-1.5 text-xs", className)}
      {...props}
    />
  );
}

export default SelectLabel;
