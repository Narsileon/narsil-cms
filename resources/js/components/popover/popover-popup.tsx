import { Popover } from "@base-ui/react/popover";
import { cn } from "@narsil-cms/lib/utils";

function PopoverContent({ className, ...props }: Popover.Popup.Props) {
  return (
    <Popover.Popup
      data-slot="popover-content"
      className={cn(
        "z-50 flex w-72 flex-col gap-2.5 rounded-lg bg-popover p-2.5 text-sm text-popover-foreground shadow-md ring-1 ring-foreground/10 outline-hidden duration-100",
        "data-[side=bottom]:slide-in-from-top-2",
        "data-[side=inline-end]:slide-in-from-left-2",
        "data-[side=inline-start]:slide-in-from-right-2",
        "data-[side=left]:slide-in-from-right-2",
        "data-[side=right]:slide-in-from-left-2",
        "data-[side=top]:slide-in-from-bottom-2",
        "data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95",
        "data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95",
        "origin-(--transform-origin)",
        className,
      )}
      {...props}
    />
  );
}

export default PopoverContent;
