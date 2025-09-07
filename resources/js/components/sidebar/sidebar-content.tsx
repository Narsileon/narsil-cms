import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";

type SidebarContentProps = React.ComponentProps<"div"> & {};

function SidebarContent({ className, ...props }: SidebarContentProps) {
  return (
    <div
      data-slot="sidebar-content"
      data-sidebar="content"
      className={cn(
        "flex min-h-0 flex-1 flex-col gap-2 overflow-auto p-2",
        "group-data-[collapsible=icon]:overflow-hidden",
        className,
      )}
      {...props}
    />
  );
}

export default SidebarContent;
