import { Select } from "@base-ui/react/select";
import { cn } from "@narsil-cms/lib/utils";

function SelectPositioner({
  className,
  align = "center",
  alignItemWithTrigger = true,
  alignOffset = 0,
  side = "bottom",
  sideOffset = 4,
  ...props
}: Select.Positioner.Props) {
  return (
    <Select.Positioner
      data-slot="select-positioner"
      className={cn("isolate z-50", className)}
      align={align}
      alignItemWithTrigger={alignItemWithTrigger}
      alignOffset={alignOffset}
      side={side}
      sideOffset={sideOffset}
      {...props}
    />
  );
}

export default SelectPositioner;
