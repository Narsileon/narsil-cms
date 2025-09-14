import { Slot } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type SidebarMenuSubButtonProps = React.ComponentProps<"a"> & {
  asChild?: boolean;
  isActive?: boolean;
  size?: "sm" | "md";
};

function SidebarMenuSubButton({
  asChild = false,
  className,
  isActive = false,
  size = "md",
  ...props
}: SidebarMenuSubButtonProps) {
  const Comp = asChild ? Slot.Root : "a";

  return (
    <Comp
      data-slot="sidebar-menu-sub-button"
      data-active={isActive}
      data-sidebar="menu-sub-button"
      data-size={size}
      className={cn(
        "flex h-7 min-w-0 -translate-x-px items-center gap-2 overflow-hidden rounded-md px-2 text-sidebar-foreground ring-sidebar-ring outline-hidden",
        "active:bg-sidebar-accent active:text-sidebar-accent-foreground",
        "aria-disabled:pointer-events-none aria-disabled:opacity-50",
        "disabled:opacity-50",
        "focus-visible:ring-2 disabled:pointer-events-none",
        "hover:bg-sidebar-accent hover:text-sidebar-accent-foreground",
        "data-[active=true]:bg-sidebar-accent data-[active=true]:text-sidebar-accent-foreground",
        "[&>span:last-child]:truncate",
        "[&>svg]:size-4 [&>svg]:shrink-0 [&>svg]:text-sidebar-accent-foreground",
        size === "sm" && "text-xs",
        size === "md" && "text-sm",
        "group-data-[collapsible=icon]:hidden",
        className,
      )}
      {...props}
    />
  );
}

export default SidebarMenuSubButton;
