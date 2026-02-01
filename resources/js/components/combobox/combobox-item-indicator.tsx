import { Combobox } from "@base-ui/react";
import { cn } from "@narsil-cms/lib/utils";
import { CheckIcon } from "lucide-react";

function ComboboxItemIndicator({
  className,
  children,
  render,
  ...props
}: Combobox.ItemIndicator.Props) {
  return (
    <Combobox.ItemIndicator
      data-slot="combobox-item-indicator"
      className={cn(
        "pointer-events-none absolute right-2 flex size-4 items-center justify-center",
        className,
      )}
      render={render ?? <CheckIcon className="pointer-events-none" />}
      {...props}
    />
  );
}

export default ComboboxItemIndicator;
