import { cn } from "@narsil-cms/lib/utils";
import { ContextMenu } from "radix-ui";
import { type ComponentProps } from "react";

type ContextMenuContentProps = ComponentProps<typeof ContextMenu.Content>;

function ContextMenuContent({ className, ...props }: ContextMenuContentProps) {
  return (
    <ContextMenu.Content
      data-slot="context-menu-content"
      className={cn(
        "z-50 min-w-32 overflow-x-hidden overflow-y-auto rounded-md border bg-popover p-1 text-popover-foreground shadow-md will-change-transform",
        "data-[side=bottom]:slide-in-from-top-2",
        "data-[side=left]:slide-in-from-right-2",
        "data-[side=right]:slide-in-from-left-2",
        "data-[side=top]:slide-in-from-bottom-2",
        "data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=closed]:zoom-out-95",
        "data-[state=open]:animate-in data-[state=open]:fade-in-0 data-[state=open]:zoom-in-95",
        "data-[side=inline-start]:slide-in-from-right-2",
        "data-[side=inline-end]:slide-in-from-left-2",
        "max-h-(--radix-context-menu-content-available-height)",
        "origin-(--radix-context-menu-content-transform-origin)",
        className,
      )}
      {...props}
    />
  );
}

export default ContextMenuContent;
