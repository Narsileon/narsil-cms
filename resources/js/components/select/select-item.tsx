import { Select } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type SelectItemProps = React.ComponentProps<typeof Select.Item> & {};

function SelectItem({ className, ...props }: SelectItemProps) {
  return (
    <Select.Item
      data-slot="select-item"
      className={cn(
        "relative flex w-full cursor-pointer items-center gap-2 rounded-md py-1.5 pr-3 pl-9 text-sm outline-hidden select-none",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[disabled]:pointer-events-none data-[disabled]:opacity-50",
        className,
      )}
      {...props}
    />
  );
}

export default SelectItem;
