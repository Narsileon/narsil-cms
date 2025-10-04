import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type SidebarContentProps = ComponentProps<"div">;

function SidebarContent({ className, ...props }: SidebarContentProps) {
  return (
    <div
      data-slot="sidebar-content"
      data-sidebar="content"
      className={cn(
        "not-first:p-2 flex min-h-0 flex-1 flex-col gap-2 overflow-y-auto overflow-x-hidden",
        className,
      )}
      {...props}
    />
  );
}

export default SidebarContent;
