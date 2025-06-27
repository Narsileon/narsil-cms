import { cn } from "@/lib/utils";
import { Separator } from "@/components/ui/separator";
import type { SeparatorProps } from "@/components/ui/separator";

export type SidebarSeparatorProps = SeparatorProps & {};

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
