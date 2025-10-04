import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type SidebarGroupProps = ComponentProps<"li">;

function SidebarGroup({ className, ...props }: SidebarGroupProps) {
  return (
    <li
      data-slot="sidebar-group"
      data-sidebar="group"
      className={cn("relative flex w-full min-w-0 flex-col", className)}
      {...props}
    />
  );
}

export default SidebarGroup;
