import { Select } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type SelectTriggerProps = ComponentProps<typeof Select.Trigger> & {
  size?: "sm" | "default";
};

function SelectTrigger({
  className,
  size = "default",
  ...props
}: SelectTriggerProps) {
  return (
    <Select.Trigger
      data-slot="select-trigger"
      data-size={size}
      className={cn(
        "border-input shadow-xs flex w-fit cursor-pointer items-center justify-between gap-2 whitespace-nowrap rounded-md border bg-transparent px-2 py-2 outline-none transition-[color,box-shadow]",
        "aria-invalid:border-destructive aria-invalid:ring-destructive/20",
        "dark:aria-invalid:ring-destructive/40",
        "dark:bg-input/30 dark:hover:bg-input/50",
        "disabled:cursor-not-allowed disabled:opacity-50",
        "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-2",
        "data-[placeholder]:text-muted-foreground",
        "data-[size=default]:h-9",
        "data-[size=sm]:h-7",
        "*:data-[slot=select-value]:line-clamp-1 *:data-[slot=select-value]:flex *:data-[slot=select-value]:items-center *:data-[slot=select-value]:gap-2",
        "[&_svg:not([class*='text-'])]:text-muted-foreground [&_svg:not([class*='size-'])]:size-4 [&_svg]:pointer-events-none [&_svg]:shrink-0",
        className,
      )}
      {...props}
    />
  );
}

export default SelectTrigger;
