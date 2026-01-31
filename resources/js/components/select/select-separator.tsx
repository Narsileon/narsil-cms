import { Select } from "@base-ui/react/select";
import { cn } from "@narsil-cms/lib/utils";

function SelectSeparator({ className, ...props }: Select.Separator.Props) {
  return (
    <Select.Separator
      data-slot="select-separator"
      className={cn("pointer-events-none -mx-1 my-1 h-px bg-border", className)}
      {...props}
    />
  );
}

export default SelectSeparator;
