import { Combobox } from "@base-ui/react";
import { cn } from "@narsil-cms/lib/utils";

function ComboboxChips({ className, ...props }: Combobox.Chips.Props) {
  return (
    <Combobox.Chips
      data-slot="combobox-chips"
      className={cn(
        "flex min-h-8 flex-wrap items-center gap-1 rounded-lg border border-input bg-transparent bg-clip-padding px-2.5 py-1 text-sm transition-colors dark:bg-input/30",
        "focus-within:border-ring focus-within:ring-[3px] focus-within:ring-ring/50",
        "has-aria-invalid:border-destructive has-aria-invalid:ring-[3px] has-aria-invalid:ring-destructive/20 dark:has-aria-invalid:border-destructive/50 dark:has-aria-invalid:ring-destructive/40",
        "has-data-[slot=combobox-chip]:px-1",
        className,
      )}
      {...props}
    />
  );
}

export default ComboboxChips;
