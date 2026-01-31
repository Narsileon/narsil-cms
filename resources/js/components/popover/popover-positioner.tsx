import { Popover } from "@base-ui/react/popover";
import { cn } from "@narsil-cms/lib/utils";

function PopoverPositioner({
  className,
  align = "center",
  alignOffset = 0,
  side = "bottom",
  sideOffset = 4,
  ...props
}: Popover.Positioner.Props) {
  return (
    <Popover.Positioner
      data-slot="popover-positioner"
      className={cn("isolate z-50", className)}
      align={align}
      alignOffset={alignOffset}
      side={side}
      sideOffset={sideOffset}
      {...props}
    />
  );
}

export default PopoverPositioner;
