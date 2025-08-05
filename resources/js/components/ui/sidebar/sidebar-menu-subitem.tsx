import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";

type SidebarMenuSubItemProps = React.ComponentProps<"li"> & {};

function SidebarMenuSubItem({ className, ...props }: SidebarMenuSubItemProps) {
  return (
    <li
      data-slot="sidebar-menu-sub-item"
      data-sidebar="menu-sub-item"
      className={cn("group/menu-sub-item relative", className)}
      {...props}
    />
  );
}

export default SidebarMenuSubItem;
