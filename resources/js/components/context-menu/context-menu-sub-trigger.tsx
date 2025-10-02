import { ContextMenu } from "radix-ui";
import { type ComponentProps } from "react";

import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

type ContextMenuSubTriggerProps = ComponentProps<
  typeof ContextMenu.SubTrigger
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
    <ContextMenu.SubTrigger
      data-slot="context-menu-sub-trigger"
      data-inset={inset}
      className={cn(
        "outline-hidden flex cursor-pointer select-none items-center rounded-md px-2 py-1.5",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[inset]:pl-8",
        "data-[state=open]:bg-accent data-[state=open]:text-accent-foreground",
        "[&_svg:not([class*='size-'])]:size-4 [&_svg]:pointer-events-none [&_svg]:shrink-0",
        className,
      )}
      {...props}
    >
      {children}
      <Icon className="ml-auto" name="chevron-right" />
    </ContextMenu.SubTrigger>
  );
}

export default ContextMenuSubTrigger;
