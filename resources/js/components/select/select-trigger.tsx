import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/icon";
import { Select as SelectPrimitive } from "radix-ui";

type SelectTriggerProps = React.ComponentProps<
  typeof SelectPrimitive.Trigger
> & {
  size?: "sm" | "default";
};

function SelectTrigger({
  className,
  size = "default",
  children,
  ...props
}: SelectTriggerProps) {
  return (
    <SelectPrimitive.Trigger
      data-slot="select-trigger"
      data-size={size}
      className={cn(
        "flex w-fit items-center justify-between gap-2 rounded-md border border-input bg-transparent px-2 py-2 text-sm whitespace-nowrap shadow-xs transition-[color,box-shadow] outline-none",
        "aria-invalid:border-destructive aria-invalid:ring-destructive/20",
        "dark:aria-invalid:ring-destructive/40",
        "dark:bg-input/30 dark:hover:bg-input/50",
        "disabled:cursor-not-allowed disabled:opacity-50",
        "focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/50",
        "data-[placeholder]:text-muted-foreground",
        "data-[size=default]:h-9",
        "data-[size=sm]:h-8",
        "*:data-[slot=select-value]:line-clamp-1 *:data-[slot=select-value]:flex *:data-[slot=select-value]:items-center *:data-[slot=select-value]:gap-2",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4 [&_svg:not([class*='text-'])]:text-muted-foreground",
        className,
      )}
      {...props}
    >
      {children}
      <SelectPrimitive.Icon asChild>
        <Icon name="chevron-down" />
      </SelectPrimitive.Icon>
    </SelectPrimitive.Trigger>
  );
}

export default SelectTrigger;
