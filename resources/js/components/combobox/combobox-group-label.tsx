import { Combobox } from "@base-ui/react";
import { cn } from "@narsil-cms/lib/utils";

function ComboboxGroupLabel({ className, ...props }: Combobox.GroupLabel.Props) {
  return (
    <Combobox.GroupLabel
      data-slot="combobox-group-label"
      className={cn("px-2 py-1.5 text-xs text-muted-foreground", className)}
      {...props}
    />
  );
}

export default ComboboxGroupLabel;
