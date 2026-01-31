import { Select } from "@base-ui/react/select";
import { cn } from "@narsil-cms/lib/utils";

function SelectLabel({ className, ...props }: Select.GroupLabel.Props) {
  return (
    <Select.GroupLabel
      data-slot="select-group-label"
      className={cn("px-1.5 py-1 text-xs text-muted-foreground", className)}
      {...props}
    />
  );
}

export default SelectLabel;
