import { cn } from "@/lib/utils";
import { ContextMenu as ContextMenuPrimitive } from "radix-ui";

type ContextMenuLabelProps = React.ComponentProps<
  typeof ContextMenuPrimitive.Label
> & {
  inset?: boolean;
};

function ContextMenuLabel({
  className,
  inset,
  ...props
}: ContextMenuLabelProps) {
  return (
    <ContextMenuPrimitive.Label
      data-slot="context-menu-label"
      data-inset={inset}
      className={cn(
        "text-foreground px-2 py-1.5 text-sm font-medium",
        "data-[inset]:pl-8",
        className,
      )}
      {...props}
    />
  );
}

export default ContextMenuLabel;
