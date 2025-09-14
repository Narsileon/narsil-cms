import { Select } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type SelectSeparatorProps = React.ComponentProps<typeof Select.Separator> & {};

function SelectSeparator({ className, ...props }: SelectSeparatorProps) {
  return (
    <Select.Separator
      data-slot="select-separator"
      className={cn("pointer-events-none -mx-1 my-1 h-px bg-border", className)}
      {...props}
    />
  );
}

export default SelectSeparator;
