import { Select } from "radix-ui";

import { separatorRootVariants } from "@narsil-cms/components/separator";
import { cn } from "@narsil-cms/lib/utils";

type SelectSeparatorProps = React.ComponentProps<typeof Select.Separator> & {};

function SelectSeparator({ className, ...props }: SelectSeparatorProps) {
  return (
    <Select.Separator
      data-slot="select-separator"
      className={cn(separatorRootVariants({ variant: "menu" }), className)}
      {...props}
    />
  );
}

export default SelectSeparator;
