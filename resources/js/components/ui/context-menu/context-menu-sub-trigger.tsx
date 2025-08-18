import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { ContextMenu as ContextMenuPrimitive } from "radix-ui";
import { Icon } from "@narsil-cms/components/ui/icon";

type ContextMenuSubTriggerProps = React.ComponentProps<
  typeof ContextMenuPrimitive.SubTrigger
> & {
  inset?: boolean;
};

function ContextMenuSubTrigger({
  children,
  className,
  inset,
  ...props
}: ContextMenuSubTriggerProps) {
  return (
    <ContextMenuPrimitive.SubTrigger
      data-slot="context-menu-sub-trigger"
      data-inset={inset}
      className={cn(
        "flex cursor-pointer items-center rounded-md px-2 py-1.5 text-sm outline-hidden select-none",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[inset]:pl-8",
        "data-[state=open]:bg-accent data-[state=open]:text-accent-foreground",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    >
      {children}
      <Icon className="ml-auto" name="chevron-right" />
    </ContextMenuPrimitive.SubTrigger>
  );
}

export default ContextMenuSubTrigger;
