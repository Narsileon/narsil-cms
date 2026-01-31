import { Popover } from "@base-ui/react/popover";
import { cn } from "@narsil-cms/lib/utils";

function PopoverTitle({ className, ...props }: Popover.Title.Props) {
  return (
    <Popover.Title data-slot="popover-title" className={cn("font-medium", className)} {...props} />
  );
}

export default PopoverTitle;
