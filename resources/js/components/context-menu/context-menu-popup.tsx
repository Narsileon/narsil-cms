import { ContextMenu } from "@base-ui/react/context-menu";
import { cn } from "@narsil-cms/lib/utils";

function ContextMenuPopup({ className, ...props }: ContextMenu.Popup.Props) {
  return (
    <ContextMenu.Popup
      data-slot="context-menu-popup"
      className={cn(
        "z-50 min-w-36 overflow-x-hidden overflow-y-auto rounded-lg bg-popover p-1 text-popover-foreground shadow-md ring-1 ring-foreground/10 duration-100 outline-none",
        "data-[side=bottom]:slide-in-from-top-2",
        "data-[side=inline-end]:slide-in-from-left-2",
        "data-[side=inline-start]:slide-in-from-right-2",
        "data-[side=left]:slide-in-from-right-2",
        "data-[side=right]:slide-in-from-left-2",
        "data-[side=top]:slide-in-from-bottom-2",
        "data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95",
        "data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95",
        "max-h-(--available-height) origin-(--transform-origin)",
        className,
      )}
      {...props}
    />
  );
}

export default ContextMenuPopup;
