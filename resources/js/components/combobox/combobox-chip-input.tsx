import { Combobox } from "@base-ui/react";
import { cn } from "@narsil-cms/lib/utils";

function ComboboxChipsInput({ className, ...props }: Combobox.Input.Props) {
  return (
    <Combobox.Input
      data-slot="combobox-chip-input"
      className={cn("min-w-16 flex-1 outline-none", className)}
      {...props}
    />
  );
}

export default ComboboxChipsInput;
