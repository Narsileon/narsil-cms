import { DropdownMenu } from "radix-ui";
import { type ComponentProps } from "react";

import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

type DropdownMenuRadioItemProps = ComponentProps<typeof DropdownMenu.RadioItem>;

function DropdownMenuRadioItem({
  children,
  className,
  ...props
}: DropdownMenuRadioItemProps) {
  return (
    <DropdownMenu.RadioItem
      data-slot="dropdown-menu-radio-item"
      className={cn(
        "outline-hidden relative flex cursor-pointer select-none items-center gap-2 rounded-md py-1.5 pl-8 pr-2",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[disabled]:pointer-events-none data-[disabled]:opacity-50",
        "[&_svg:not([class*='size-'])]:size-4 [&_svg]:pointer-events-none [&_svg]:shrink-0",
        className,
      )}
      {...props}
    >
      <span className="pointer-events-none absolute left-2 flex size-3.5 items-center justify-center">
        <DropdownMenu.ItemIndicator>
          <Icon className="size-2 fill-current" name="circle" />
        </DropdownMenu.ItemIndicator>
      </span>
      {children}
    </DropdownMenu.RadioItem>
  );
}

export default DropdownMenuRadioItem;
