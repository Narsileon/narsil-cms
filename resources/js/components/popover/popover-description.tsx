import { Popover } from "@base-ui/react/popover";
import { cn } from "@narsil-cms/lib/utils";

function PopoverDescription({ className, ...props }: Popover.Description.Props) {
  return (
    <Popover.Description
      data-slot="popover-description"
      className={cn("text-muted-foreground", className)}
      {...props}
    />
  );
}

export default PopoverDescription;
