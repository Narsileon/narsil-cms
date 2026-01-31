import { Menu } from "@base-ui/react/menu";
import { cn } from "@narsil-cms/lib/utils";

function DropdownMenuPositioner({
  className,
  align = "start",
  alignOffset = 0,
  side = "bottom",
  sideOffset = 4,
  ...props
}: Menu.Positioner.Props) {
  return (
    <Menu.Positioner
      data-slot="dropdown-menu-positioner"
      className={cn("isolate z-50 outline-none", className)}
      align={align}
      alignOffset={alignOffset}
      side={side}
      sideOffset={sideOffset}
      {...props}
    />
  );
}

export default DropdownMenuPositioner;
