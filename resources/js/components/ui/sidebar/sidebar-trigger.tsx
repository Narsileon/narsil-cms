import { Button, ButtonProps } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import { PanelLeftIcon } from "lucide-react";
import { VisuallyHidden } from "@/components/ui/visually-hidden";
import useSidebar from "./sidebar-context";

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
      <VisuallyHidden>Toggle Sidebar</VisuallyHidden>
    </Button>
  );
}

export default SidebarTrigger;
