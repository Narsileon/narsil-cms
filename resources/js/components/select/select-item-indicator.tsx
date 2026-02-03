import { Select } from "@base-ui/react/select";
import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

function SelectItemIndicator({ className, render, ...props }: Select.ItemIndicator.Props) {
  return (
    <Select.ItemIndicator
      data-slot="select-item-indicator"
      className={cn(
        "pointer-events-none absolute right-2 flex size-4 items-center justify-center",
        className,
      )}
      render={render ?? <Icon className="size-4" name="check" />}
      {...props}
    />
  );
}

export default SelectItemIndicator;
