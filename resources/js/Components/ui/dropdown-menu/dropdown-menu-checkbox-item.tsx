import { cn } from "@/Components";
import { CheckboxItem, ItemIndicator } from "@radix-ui/react-dropdown-menu";
import { CheckIcon } from "lucide-react";

export type DropdownMenuCheckboxItemProps = React.ComponentProps<
  typeof CheckboxItem
> & {};

function DropdownMenuCheckboxItem({
  className,
  children,
  checked,
  ...props
}: DropdownMenuCheckboxItemProps) {
  return (
    <CheckboxItem
      data-slot="dropdown-menu-checkbox-item"
      className={cn(
        "relative flex cursor-default items-center gap-2 rounded-sm py-1.5 pr-2 pl-8 text-sm outline-hidden select-none",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[disabled]:pointer-events-none data-[disabled]:opacity-50",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      checked={checked}
      {...props}
    >
      <span className="pointer-events-none absolute left-2 flex size-3.5 items-center justify-center">
        <ItemIndicator>
          <CheckIcon className="size-4" />
        </ItemIndicator>
      </span>
      {children}
    </CheckboxItem>
  );
}

export default DropdownMenuCheckboxItem;
