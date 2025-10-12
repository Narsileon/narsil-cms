import { cn } from "@narsil-cms/lib/utils";
import { Select } from "radix-ui";
import { type ComponentProps } from "react";

type SelectContentProps = ComponentProps<typeof Select.Content>;

function SelectContent({ className, position = "popper", ...props }: SelectContentProps) {
  return (
    <Select.Content
      data-slot="select-content"
      className={cn(
        "bg-popover text-popover-foreground relative z-50 overflow-y-auto overflow-x-hidden rounded-xl border shadow-md",
        "data-[state=closed]:animate-out data-[state=open]:animate-in",
        "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
        "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95",
        "data-[side=bottom]:slide-in-from-top-2",
        "data-[side=left]:slide-in-from-right-2",
        "data-[side=right]:slide-in-from-left-2",
        "data-[side=top]:slide-in-from-bottom-2",
        "max-h-(--radix-select-content-available-height)",
        "origin-(--radix-select-content-transform-origin) will-change-transform",
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
    />
  );
}

export default SelectContent;
