import { ContextMenu } from "@base-ui/react/context-menu";
import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

function ContextMenuCheckboxItemIndicator({
  children,
  className,
  ...props
}: ContextMenu.CheckboxItemIndicator.Props) {
  return (
    <ContextMenu.CheckboxItemIndicator
      data-slot="context-menu-checkbox-item-indicator"
      className={cn("pointer-events-none absolute right-2", className)}
      {...props}
    >
      {children ?? <Icon name="check" />}
    </ContextMenu.CheckboxItemIndicator>
  );
}

export default ContextMenuCheckboxItemIndicator;
