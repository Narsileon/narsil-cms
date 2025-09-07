import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Separator } from "@narsil-cms/components/separator";

type SidebarSeparatorProps = React.ComponentProps<typeof Separator> & {};

function SidebarSeparator({ className, ...props }: SidebarSeparatorProps) {
  return (
    <Separator
      data-slot="sidebar-separator"
      data-sidebar="separator"
      className={cn("bg-sidebar-border mx-2 w-auto", className)}
      {...props}
    />
  );
}

export default SidebarSeparator;
