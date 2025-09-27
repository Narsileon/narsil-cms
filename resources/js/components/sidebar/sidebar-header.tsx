import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type SidebarHeaderProps = ComponentProps<"div"> & {};

function SidebarHeader({ className, ...props }: SidebarHeaderProps) {
  return (
    <div
      data-slot="sidebar-header"
      data-sidebar="header"
      className={cn("grid items-center gap-2 p-2", className)}
      {...props}
    />
  );
}

export default SidebarHeader;
