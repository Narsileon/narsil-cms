import { cn } from "@narsil-cms/lib/utils";
import { Select as SelectPrimitive } from "radix-ui";
import SelectScrollDownButton from "./select-scroll-down-button";
import SelectScrollUpButton from "./select-scroll-up-button";

type SelectContentProps = React.ComponentProps<
  typeof SelectPrimitive.Content
> & {};

function SelectContent({
  children,
  className,
  position = "popper",
  ...props
}: SelectContentProps) {
  return (
    <SelectPrimitive.Portal>
      <SelectPrimitive.Content
        data-slot="select-content"
        className={cn(
          "bg-popover text-popover-foreground relative z-50 min-w-[8rem] overflow-x-hidden overflow-y-auto rounded-md border shadow-md",
          "data-[state=open]:animate-in data-[state=closed]:animate-out",
          "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
          "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95",
          "data-[side=bottom]:slide-in-from-top-2",
          "data-[side=left]:slide-in-from-right-2",
          "data-[side=right]:slide-in-from-left-2",
          "data-[side=top]:slide-in-from-bottom-2",
          "max-h-(--radix-select-content-available-height)",
          "origin-(--radix-select-content-transform-origin)",
          position === "popper" &&
            cn(
              "data-[side=bottom]:translate-y-1",
              "data-[side=left]:-translate-x-1",
              "data-[side=right]:translate-x-1",
              "data-[side=top]:-translate-y-1",
            ),
          className,
        )}
        position={position}
        {...props}
      >
        <SelectScrollUpButton />
        <SelectPrimitive.Viewport
          className={cn(
            "p-1",
            position === "popper" &&
              "h-[var(--radix-select-trigger-height)] w-full min-w-[var(--radix-select-trigger-width)] scroll-my-1",
          )}
        >
          {children}
        </SelectPrimitive.Viewport>
        <SelectScrollDownButton />
      </SelectPrimitive.Content>
    </SelectPrimitive.Portal>
  );
}

export default SelectContent;
