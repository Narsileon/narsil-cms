import { Tooltip } from "@base-ui/react/tooltip";
import { cn } from "@narsil-cms/lib/utils";

function TooltipPopup({ className, ...props }: Tooltip.Popup.Props) {
  return (
    <Tooltip.Popup
      data-slot="tooltip-content"
      className={cn(
        "z-50 w-fit max-w-xs rounded-md bg-foreground px-3 py-1.5 text-xs text-background",
        "data-[side=bottom]:slide-in-from-top-2",
        "data-[side=inline-end]:slide-in-from-left-2",
        "data-[side=inline-start]:slide-in-from-right-2",
        "data-[side=left]:slide-in-from-right-2",
        "data-[side=right]:slide-in-from-left-2",
        "data-[side=top]:slide-in-from-bottom-2",
        "data-[state=delayed-open]:animate-in",
        "data-[state=delayed-open]:fade-in-0",
        "data-[state=delayed-open]:zoom-in-95",
        "data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95",
        "data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95",
        "origin-(--transform-origin)",
        className,
      )}
      {...props}
    />
  );
}

export default TooltipPopup;
