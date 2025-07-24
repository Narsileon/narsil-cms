import { cn } from "@narsil-cms/lib/utils";

type SidebarMenuBadgeProps = React.ComponentProps<"div"> & {};

function SidebarMenuBadge({ className, ...props }: SidebarMenuBadgeProps) {
  return (
    <div
      data-slot="sidebar-menu-badge"
      data-sidebar="menu-badge"
      className={cn(
        "text-sidebar-foreground pointer-events-none absolute right-1 flex h-5 min-w-5 items-center justify-center rounded-md px-1 text-xs font-medium tabular-nums select-none",
        "peer-data-[active=true]/menu-button:text-sidebar-accent-foreground",
        "peer-data-[size=default]/menu-button:top-1.5",
        "peer-data-[size=lg]/menu-button:top-2.5",
        "peer-data-[size=sm]/menu-button:top-1",
        "peer-hover/menu-button:text-sidebar-accent-foreground",
        "group-data-[collapsible=icon]:hidden",
        className,
      )}
      {...props}
    />
  );
}
export default SidebarMenuBadge;
