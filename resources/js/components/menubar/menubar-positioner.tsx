import { Menu } from "@base-ui/react/menu";
import { cn } from "@narsil-cms/lib/utils";

function MenubarPositioner({
  className,
  align = "start",
  alignOffset = -4,
  side = "bottom",
  sideOffset = 8,
  ...props
}: Menu.Positioner.Props) {
  return (
    <Menu.Positioner
      data-slot="menubar-positioner"
      className={cn("isolate z-50 outline-none", className)}
      align={align}
      alignOffset={alignOffset}
      side={side}
      sideOffset={sideOffset}
      {...props}
    />
  );
}

export default MenubarPositioner;
