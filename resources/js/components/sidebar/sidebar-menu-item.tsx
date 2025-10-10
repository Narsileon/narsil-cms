import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type SidebarMenuItemProps = ComponentProps<"li">;

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
