import { cn } from "@narsil-ui/lib/utils";
import { type ComponentProps } from "react";

function SidebarGroup({ className, ...props }: ComponentProps<"li">) {
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
