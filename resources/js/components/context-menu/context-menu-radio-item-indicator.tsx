import { ContextMenu } from "@base-ui/react/context-menu";
import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

function ContextMenuRadioItemIndicator({
  children,
  className,
  ...props
}: ContextMenu.RadioItemIndicator.Props) {
  return (
    <ContextMenu.RadioItemIndicator
      data-slot="context-menu-radio-item-indicator"
      className={cn("pointer-events-none absolute right-2", className)}
      {...props}
    >
      {children ?? <Icon name="check" />}
    </ContextMenu.RadioItemIndicator>
  );
}

export default ContextMenuRadioItemIndicator;
