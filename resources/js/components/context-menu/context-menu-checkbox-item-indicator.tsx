import { ContextMenu } from "@base-ui/react/context-menu";
import { cn } from "@narsil-cms/lib/utils";
import { CheckIcon } from "lucide-react";

function ContextMenuCheckboxItemIndicator({
  className,
  render,
  ...props
}: ContextMenu.CheckboxItemIndicator.Props) {
  return (
    <ContextMenu.CheckboxItemIndicator
      data-slot="context-menu-checkbox-item-indicator"
      className={cn("pointer-events-none absolute right-2", className)}
      render={render ?? <CheckIcon />}
      {...props}
    />
  );
}

export default ContextMenuCheckboxItemIndicator;
