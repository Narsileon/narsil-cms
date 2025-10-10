import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type SidebarFooterProps = ComponentProps<"div">;

function SidebarFooter({ className, ...props }: SidebarFooterProps) {
  return (
    <div
      data-slot="sidebar-footer"
      data-sidebar="footer"
      className={cn("flex flex-col gap-2 p-2", className)}
      {...props}
    />
  );
}

export default SidebarFooter;
