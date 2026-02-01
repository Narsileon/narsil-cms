import { Combobox } from "@base-ui/react";
import { cn } from "@narsil-cms/lib/utils";

function ComboboxPopup({ className, ...props }: Combobox.Popup.Props) {
  return (
    <Combobox.Popup
      data-slot="combobox-popup"
      className={cn(
        "group/combobox-popup",
        "relative max-h-72 min-w-36 overflow-hidden rounded-lg bg-popover text-popover-foreground shadow-md ring-1 ring-foreground/10 duration-100",
        "*:data-[slot=input-group]:m-1 *:data-[slot=input-group]:mb-0 *:data-[slot=input-group]:h-8 *:data-[slot=input-group]:border-input/30 *:data-[slot=input-group]:bg-input/30 *:data-[slot=input-group]:shadow-none",
        "data-[chips=true]:min-w-(--anchor-width)",
        "data-[side=bottom]:slide-in-from-top-2",
        "data-[side=inline-end]:slide-in-from-left-2",
        "data-[side=inline-start]:slide-in-from-right-22",
        "data-[side=left]:slide-in-from-right-2",
        "data-[side=right]:slide-in-from-left-2",
        "data-[side=top]:slide-in-from-bottom-2",
        "data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95",
        "data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95",
        "w-(--anchor-width) max-w-(--available-width) origin-(--transform-origin)",
        className,
      )}
      {...props}
    />
  );
}

export default ComboboxPopup;
