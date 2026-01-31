import { Select } from "@base-ui/react/select";
import { cn } from "@narsil-cms/lib/utils";

type SelectPopupProps = Select.Popup.Props & {
  alignItemWithTrigger?: boolean;
};

function SelectPopup({ alignItemWithTrigger = true, className, ...props }: SelectPopupProps) {
  return (
    <Select.Popup
      data-slot="select-content"
      data-align-trigger={alignItemWithTrigger}
      className={cn(
        "relative isolate z-50 min-w-36 overflow-x-hidden overflow-y-auto rounded-lg bg-popover text-popover-foreground shadow-md ring-1 ring-foreground/10 duration-100",
        "data-[align-trigger=true]:animate-none",
        "data-[side=bottom]:slide-in-from-top-2",
        "data-[side=inline-end]:slide-in-from-left-2",
        "data-[side=inline-start]:slide-in-from-right-2",
        "data-[side=left]:slide-in-from-right-2",
        "data-[side=right]:slide-in-from-left-2",
        "data-[side=top]:slide-in-from-bottom-2",
        "data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95",
        "data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95",
        "max-h-(--available-height) w-(--anchor-width) origin-(--transform-origin)",
        className,
      )}
      {...props}
    />
  );
}

export default SelectPopup;
