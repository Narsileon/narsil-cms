import { Button, ButtonProps } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import { PanelLeftIcon } from "lucide-react";
import { useSidebar } from "./sidebar-provider";

export type SidebarTriggerProps = ButtonProps & {};

function SidebarTrigger({ className, onClick, ...props }: SidebarTriggerProps) {
  const { toggleSidebar } = useSidebar();

  return (
    <Button
      data-slot="sidebar-trigger"
      data-sidebar="trigger"
      className={cn("size-7", className)}
      onClick={(e) => {
        onClick?.(e);

        toggleSidebar();
      }}
      size="icon"
      variant="ghost"
      {...props}
    >
      <PanelLeftIcon />
      <span className="sr-only">Toggle Sidebar</span>
    </Button>
  );
}

export default SidebarTrigger;
