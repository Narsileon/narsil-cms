import { Combobox } from "@base-ui/react/combobox";
import { cn } from "@narsil-cms/lib/utils";

function ComboboxPositioner({
  className,
  align = "start",
  alignOffset = 0,
  side = "bottom",
  sideOffset = 8,
  ...props
}: Combobox.Positioner.Props) {
  return (
    <Combobox.Positioner
      data-slot="combobox-positioner"
      className={cn("isolate z-50", className)}
      align={align}
      alignOffset={alignOffset}
      side={side}
      sideOffset={sideOffset}
      {...props}
    />
  );
}

export default ComboboxPositioner;
