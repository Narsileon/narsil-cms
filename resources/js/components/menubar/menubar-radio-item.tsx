import { Menubar } from "radix-ui";

import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

type MenubarRadioItemProps = React.ComponentProps<
  typeof Menubar.RadioItem
> & {};

function MenubarRadioItem({
  children,
  className,
  ...props
}: MenubarRadioItemProps) {
  return (
    <Menubar.RadioItem
      data-slot="menubar-radio-item"
      className={cn(
        "relative flex cursor-pointer items-center gap-2 rounded-md py-1.5 pr-2 pl-8 outline-hidden select-none",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[disabled]:pointer-events-none data-[disabled]:opacity-50",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    >
      <span className="pointer-events-none absolute left-2 flex size-3.5 items-center justify-center">
        <Menubar.ItemIndicator>
          <Icon className="size-2 fill-current" name="circle" />
        </Menubar.ItemIndicator>
      </span>
      {children}
    </Menubar.RadioItem>
  );
}

export default MenubarRadioItem;
