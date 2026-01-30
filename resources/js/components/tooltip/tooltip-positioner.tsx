import { Tooltip } from "@base-ui/react/tooltip";
import { cn } from "@narsil-cms/lib/utils";

function TooltipPositioner({
  className,
  side = "top",
  sideOffset = 4,
  align = "center",
  alignOffset = 0,
  ...props
}: Tooltip.Positioner.Props) {
  return (
    <Tooltip.Positioner
      className={cn("isolate z-50", className)}
      align={align}
      alignOffset={alignOffset}
      side={side}
      sideOffset={sideOffset}
      {...props}
    />
  );
}

export default TooltipPositioner;
