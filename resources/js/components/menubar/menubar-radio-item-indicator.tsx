import { Menu } from "@base-ui/react/menu";
import { cn } from "@narsil-cms/lib/utils";
import { CheckIcon } from "lucide-react";

function MenubarRadioItemIndicator({ className, render, ...props }: Menu.RadioItemIndicator.Props) {
  return (
    <Menu.RadioItemIndicator
      data-slot="menubar-radio-item-indicator"
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

export default MenubarRadioItemIndicator;
