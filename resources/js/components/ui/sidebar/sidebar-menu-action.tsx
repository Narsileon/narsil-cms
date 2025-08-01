import { cn } from "@narsil-cms/lib/utils";
import { Slot as SlotPrimitive } from "radix-ui";

type SidebarMenuActionProps = React.ComponentProps<"button"> & {
  asChild?: boolean;
  showOnHover?: boolean;
};

function SidebarMenuAction({
  asChild = false,
  className,
  showOnHover = false,
  ...props
}: SidebarMenuActionProps) {
  const Comp = asChild ? SlotPrimitive.Slot : "button";

  return (
    <Comp
      data-slot="sidebar-menu-action"
      data-sidebar="menu-action"
      className={cn(
        "text-sidebar-foreground ring-sidebar-ring absolute top-1.5 right-1 flex aspect-square w-5 items-center justify-center rounded-md p-0 outline-hidden transition-transform",
        "after:absolute after:-inset-2 md:after:hidden",
        "focus-visible:ring-2",
        "hover:bg-sidebar-accent hover:text-sidebar-accent-foreground",
        "peer-data-[size=default]/menu-button:top-1.5",
        "peer-data-[size=lg]/menu-button:top-2.5",
        "peer-data-[size=sm]/menu-button:top-1",
        "peer-hover/menu-button:text-sidebar-accent-foreground",
        "[&>svg]:size-4 [&>svg]:shrink-0",
        "group-data-[collapsible=icon]:hidden",
        showOnHover &&
          "peer-data-[active=true]/menu-button:text-sidebar-accent-foreground group-focus-within/menu-item:opacity-100 group-hover/menu-item:opacity-100 data-[state=open]:opacity-100 md:opacity-0",
        className,
      )}
      {...props}
    />
  );
}

export default SidebarMenuAction;
