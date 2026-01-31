import { Menu } from "@base-ui/react/menu";
import { cn } from "@narsil-cms/lib/utils";

function ContextMenuPositioner({
  className,
  align = "start",
  alignOffset = 4,
  side = "right",
  sideOffset = 0,
  ...props
}: Menu.Positioner.Props) {
  return (
    <Menu.Positioner
      data-slot="context-menu-positioner"
      className={cn("isolate z-50 outline-none", className)}
      align={align}
      alignOffset={alignOffset}
      side={side}
      sideOffset={sideOffset}
      {...props}
    />
  );
}

export default ContextMenuPositioner;
