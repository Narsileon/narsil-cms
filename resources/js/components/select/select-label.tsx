import { cn } from "@narsil-cms/lib/utils";
import { Select as SelectPrimitive } from "radix-ui";

type SelectLabelProps = React.ComponentProps<typeof SelectPrimitive.Label> & {};

function SelectLabel({ className, ...props }: SelectLabelProps) {
  return (
    <SelectPrimitive.Label
      data-slot="select-label"
      className={cn("px-2 py-1.5 text-xs text-muted-foreground", className)}
      {...props}
    />
  );
}

export default SelectLabel;
