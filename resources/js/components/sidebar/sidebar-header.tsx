import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type SidebarHeaderProps = ComponentProps<"div">;

function SidebarHeader({ className, ...props }: SidebarHeaderProps) {
  return (
    <nav
      data-slot="sidebar-header"
      data-sidebar="header"
      className={cn("grid items-center gap-2 p-2", className)}
      aria-label="Header Menu"
      {...props}
    />
  );
}

export default SidebarHeader;
