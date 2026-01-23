import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type SidebarContentProps = ComponentProps<"div">;

function SidebarContent({ className, ...props }: SidebarContentProps) {
  return (
    <nav
      data-slot="sidebar-content"
      data-sidebar="content"
      className={cn(
        "flex min-h-0 flex-1 flex-col gap-2 overflow-x-hidden overflow-y-auto not-first:p-2 not-hover:no-scrollbar",
        className,
      )}
      aria-label="Main Menu"
      {...props}
    />
  );
}

export default SidebarContent;
