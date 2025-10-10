import { cn } from "@narsil-cms/lib/utils";
import { Select } from "radix-ui";
import { type ComponentProps } from "react";

type SelectItemProps = ComponentProps<typeof Select.Item>;

function SelectItem({ className, ...props }: SelectItemProps) {
  return (
    <Select.Item
      data-slot="select-item"
      className={cn(
        "outline-hidden relative flex w-full cursor-pointer select-none items-center gap-2 rounded-md py-1.5 pl-9 pr-3",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[disabled]:pointer-events-none data-[disabled]:opacity-50",
        className,
      )}
      {...props}
    />
  );
}

export default SelectItem;
