import { Combobox } from "@base-ui/react";
import { cn } from "@narsil-cms/lib/utils";

function ComboboxList({ className, ...props }: Combobox.List.Props) {
  return (
    <Combobox.List
      data-slot="combobox-list"
      className={cn(
        "no-scrollbar scroll-py-1 overflow-y-auto overscroll-contain p-1",
        "data-empty:p-0",
        "max-h-[min(calc(--spacing(72)---spacing(9)),calc(var(--available-height)---spacing(9)))]",
        className,
      )}
      {...props}
    />
  );
}

export default ComboboxList;
