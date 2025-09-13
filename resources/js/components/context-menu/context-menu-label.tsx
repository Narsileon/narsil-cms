import { ContextMenu } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type ContextMenuLabelProps = React.ComponentProps<typeof ContextMenu.Label> & {
  inset?: boolean;
};

function ContextMenuLabel({
  className,
  inset,
  ...props
}: ContextMenuLabelProps) {
  return (
    <ContextMenu.Label
      data-slot="context-menu-label"
      data-inset={inset}
      className={cn(
        "px-2 py-1.5 text-sm font-medium text-foreground",
        "data-[inset]:pl-8",
        className,
      )}
      {...props}
    />
  );
}

export default ContextMenuLabel;
