import { cn } from "@/components";
import { Select as SelectPrimitive } from "radix-ui";

export type SelectSeparatorProps = React.ComponentProps<
  typeof SelectPrimitive.Separator
> & {};

function SelectSeparator({ className, ...props }: SelectSeparatorProps) {
  return (
    <SelectPrimitive.Separator
      data-slot="select-separator"
      className={cn("bg-border pointer-events-none -mx-1 my-1 h-px", className)}
      {...props}
    />
  );
}

export default SelectSeparator;
