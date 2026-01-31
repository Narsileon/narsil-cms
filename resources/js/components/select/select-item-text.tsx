import { Select } from "@base-ui/react/select";
import { cn } from "@narsil-cms/lib/utils";

function SelectItemText({ className, ...props }: Select.ItemText.Props) {
  return (
    <Select.ItemText
      data-slot="select-item-text"
      className={cn("flex flex-1 shrink-0 gap-2 whitespace-nowrap", className)}
      {...props}
    />
  );
}

export default SelectItemText;
