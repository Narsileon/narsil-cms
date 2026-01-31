import { Menu } from "@base-ui/react/menu";
import { cn } from "@narsil-cms/lib/utils";
import { CheckIcon } from "lucide-react";

function MenubarCheckboxItemIndicator({
  className,
  render,
  ...props
}: Menu.CheckboxItemIndicator.Props) {
  return (
    <Menu.CheckboxItemIndicator
      data-slot="menubar-checkbox-item-indicator"
      className={cn(
        "pointer-events-none absolute left-1.5 flex size-4 items-center justify-center",
        "[&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      render={render ?? <CheckIcon />}
      {...props}
    />
  );
}

export default MenubarCheckboxItemIndicator;
