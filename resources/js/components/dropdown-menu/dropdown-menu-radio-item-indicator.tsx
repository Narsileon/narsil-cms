import { Menu } from "@base-ui/react/menu";
import { cn } from "@narsil-cms/lib/utils";
import { CheckIcon } from "lucide-react";

function DropdownMenuRadioItemIndicator({
  className,
  render,
  ...props
}: Menu.RadioItemIndicator.Props) {
  return (
    <Menu.RadioItemIndicator
      data-slot="dropdown-menu-radio-item-indicator"
      className={cn(
        "pointer-events-none absolute right-2 flex items-center justify-center",
        className,
      )}
      render={render ?? <CheckIcon />}
      {...props}
    />
  );
}

export default DropdownMenuRadioItemIndicator;
