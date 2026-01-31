import { ContextMenu } from "@base-ui/react/context-menu";
import { cn } from "@narsil-cms/lib/utils";
import { CheckIcon } from "lucide-react";

function ContextMenuRadioItemIndicator({
  className,
  render,
  ...props
}: ContextMenu.RadioItemIndicator.Props) {
  return (
    <ContextMenu.RadioItemIndicator
      data-slot="context-menu-radio-item-indicator"
      className={cn("pointer-events-none absolute right-2", className)}
      render={render ?? <CheckIcon />}
      {...props}
    />
  );
}

export default ContextMenuRadioItemIndicator;
