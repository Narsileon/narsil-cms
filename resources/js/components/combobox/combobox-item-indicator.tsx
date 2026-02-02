import { Combobox } from "@base-ui/react";
import { Icon } from "@narsil-cms/blocks/icon";
import { cn } from "@narsil-cms/lib/utils";

function ComboboxItemIndicator({ children, className, ...props }: Combobox.ItemIndicator.Props) {
  return (
    <Combobox.ItemIndicator
      data-slot="combobox-item-indicator"
      className={cn(
        "pointer-events-none absolute right-2 flex size-4 items-center justify-center",
        className,
      )}
      {...props}
    >
      {children ?? <Icon className="pointer-events-none" name="check" />}
    </Combobox.ItemIndicator>
  );
}

export default ComboboxItemIndicator;
