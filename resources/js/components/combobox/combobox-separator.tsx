import { Combobox } from "@base-ui/react";
import { cn } from "@narsil-cms/lib/utils";

function ComboboxSeparator({ className, ...props }: Combobox.Separator.Props) {
  return (
    <Combobox.Separator
      data-slot="combobox-separator"
      className={cn("-mx-1 my-1 h-px bg-border", className)}
      {...props}
    />
  );
}

export default ComboboxSeparator;
