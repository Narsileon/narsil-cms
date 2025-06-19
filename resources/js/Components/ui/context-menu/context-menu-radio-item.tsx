import { CircleIcon } from "lucide-react";
import { cn } from "@/Components";
import { ItemIndicator, RadioItem } from "@radix-ui/react-context-menu";

export type ContextMenuRadioItemProps = React.ComponentProps<
  typeof RadioItem
> & {};

function ContextMenuRadioItem({
  className,
  children,
  ...props
}: ContextMenuRadioItemProps) {
  return (
    <RadioItem
      data-slot="context-menu-radio-item"
      className={cn(
        "relative flex cursor-default items-center gap-2 rounded-sm py-1.5 pr-2 pl-8 text-sm outline-hidden select-none",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[disabled]:pointer-events-none data-[disabled]:opacity-50",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    >
      <span className="pointer-events-none absolute left-2 flex size-3.5 items-center justify-center">
        <ItemIndicator>
          <CircleIcon className="size-2 fill-current" />
        </ItemIndicator>
      </span>
      {children}
    </RadioItem>
  );
}

export default ContextMenuRadioItem;
