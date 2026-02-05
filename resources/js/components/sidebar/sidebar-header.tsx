import { cn } from "@narsil-ui/lib/utils";
import { type ComponentProps } from "react";

function SidebarHeader({ className, ...props }: ComponentProps<"div">) {
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
