import { cn } from "@narsil-ui/lib/utils";
import { type ComponentProps } from "react";

function SidebarGroupContent({ className, ...props }: ComponentProps<"ul">) {
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
