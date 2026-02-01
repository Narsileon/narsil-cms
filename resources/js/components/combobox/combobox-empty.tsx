import { Combobox } from "@base-ui/react";
import { cn } from "@narsil-cms/lib/utils";

function ComboboxEmpty({ className, ...props }: Combobox.Empty.Props) {
  return (
    <Combobox.Empty
      data-slot="combobox-empty"
      className={cn(
        "hidden w-full justify-center py-2 text-center text-sm text-muted-foreground",
        "group-data-empty/combobox-content:flex",
        className,
      )}
      {...props}
    />
  );
}

export default ComboboxEmpty;
