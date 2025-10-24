import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";
import { ContextMenu } from "radix-ui";
import { type ComponentProps } from "react";

type ContextMenuSubTriggerProps = ComponentProps<typeof ContextMenu.SubTrigger> & {
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
        "flex cursor-pointer items-center rounded-md px-2 py-1.5 outline-hidden select-none",
        "focus:bg-accent focus:text-accent-foreground",
        "data-inset:pl-8",
        "data-[state=open]:bg-accent data-[state=open]:text-accent-foreground",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4",
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
