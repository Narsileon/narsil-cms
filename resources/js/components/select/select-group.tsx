import { Select } from "@base-ui/react/select";
import { cn } from "@narsil-cms/lib/utils";

function SelectGroup({ className, ...props }: Select.Group.Props) {
  return (
    <Select.Group
      data-slot="select-group"
      className={cn("scroll-my-1 p-1", className)}
      {...props}
    />
  );
}

export default SelectGroup;
