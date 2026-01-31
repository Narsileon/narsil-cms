import { Select } from "@base-ui/react/select";
import { cn } from "@narsil-cms/lib/utils";

function SelectValue({ className, ...props }: Select.Value.Props) {
  return (
    <Select.Value
      data-slot="select-value"
      className={cn("flex flex-1 text-left", className)}
      {...props}
    />
  );
}

export default SelectValue;
