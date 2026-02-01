import { Combobox } from "@base-ui/react";
import { cn } from "@narsil-cms/lib/utils";

function ComboboxChip({ className, ...props }: Combobox.Chip.Props) {
  return (
    <Combobox.Chip
      data-slot="combobox-chip"
      className={cn(
        "flex h-[calc(--spacing(5.25))] w-fit items-center justify-center gap-1 rounded-sm bg-muted px-1.5 text-xs font-medium whitespace-nowrap text-foreground",
        "has-disabled:pointer-events-none has-disabled:cursor-not-allowed has-disabled:opacity-50",
        "has-data-[slot=combobox-chip-remove]:pr-0",
        className,
      )}
      {...props}
    />
  );
}

export default ComboboxChip;
