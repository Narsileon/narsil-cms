import { Menu } from "@base-ui/react/menu";
import { cn } from "@narsil-cms/lib/utils";
import { CheckIcon } from "lucide-react";

function DropdownMenuCheckboxItemIndicator({
  className,
  render,
  ...props
}: Menu.CheckboxItemIndicator.Props) {
  return (
    <Menu.CheckboxItemIndicator
      data-slot="dropdown-menu-checkbox-item-indicator"
      className={cn(
        "pointer-events-none absolute right-2 flex items-center justify-center",
        className,
      )}
      render={render ?? <CheckIcon />}
      {...props}
    />
  );
}

export default DropdownMenuCheckboxItemIndicator;
