import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type SidebarGroupContentProps = ComponentProps<"ul">;

function SidebarGroupContent({ className, ...props }: SidebarGroupContentProps) {
  return (
    <ul
      data-slot="sidebar-group-content"
      data-sidebar="group-content"
      className={cn("flex w-full flex-col gap-1", className)}
      {...props}
    />
  );
}

export default SidebarGroupContent;
