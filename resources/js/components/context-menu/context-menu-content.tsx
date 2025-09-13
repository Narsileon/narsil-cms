import { ContextMenu } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type ContextMenuContentProps = React.ComponentProps<
  typeof ContextMenu.Content
> & {};

function ContextMenuContent({ className, ...props }: ContextMenuContentProps) {
  return (
    <ContextMenu.Portal>
      <ContextMenu.Content
        data-slot="context-menu-content"
        className={cn(
          "z-50 min-w-[8rem] overflow-x-hidden overflow-y-auto rounded-md border bg-popover p-1 text-popover-foreground shadow-md",
          "data-[side=bottom]:slide-in-from-top-2",
          "data-[side=left]:slide-in-from-right-2",
          "data-[side=right]:slide-in-from-left-2",
          "data-[side=top]:slide-in-from-bottom-2",
          "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
          "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95",
          "data-[state=open]:animate-in data-[state=closed]:animate-out",
          "max-h-(--radix-context-menu-content-available-height)",
          "origin-(--radix-context-menu-content-transform-origin) will-change-transform",
          className,
        )}
        {...props}
      />
    </ContextMenu.Portal>
  );
}

export default ContextMenuContent;
