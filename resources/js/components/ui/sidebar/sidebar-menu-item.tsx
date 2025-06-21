import { cn } from "@/lib/utils";

export type SidebarMenuItemProps = React.ComponentProps<"li"> & {};

function SidebarMenuItem({ className, ...props }: SidebarMenuItemProps) {
  return (
    <li
      data-slot="sidebar-menu-item"
      data-sidebar="menu-item"
      className={cn("group/menu-item relative", className)}
      {...props}
    />
  );
}

export default SidebarMenuItem;
