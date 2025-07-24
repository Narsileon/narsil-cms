import { cn } from "@narsil-cms/lib/utils";
import { ContextMenu as ContextMenuPrimitive } from "radix-ui";
import { ChevronRightIcon } from "lucide-react";

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
        "flex cursor-default items-center rounded-sm px-2 py-1.5 text-sm outline-hidden select-none",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[inset]:pl-8",
        "data-[state=open]:bg-accent data-[state=open]:text-accent-foreground",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    >
      {children}
      <ChevronRightIcon className="ml-auto" />
    </ContextMenuPrimitive.SubTrigger>
  );
}

export default ContextMenuSubTrigger;
