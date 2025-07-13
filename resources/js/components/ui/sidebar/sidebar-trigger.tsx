import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import { MenuIcon } from "lucide-react";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";
import { VisuallyHidden } from "@/components/ui/visually-hidden";
import useSidebar from "./sidebar-context";

type SidebarTriggerProps = React.ComponentProps<typeof Button> & {};

function SidebarTrigger({ className, onClick, ...props }: SidebarTriggerProps) {
  const { getLabel } = useLabels();

  const { toggleSidebar } = useSidebar();

  return (
    <Tooltip tooltip={getLabel("accessibility.toggle_sidebar")}>
      <Button
        data-slot="sidebar-trigger"
        data-sidebar="trigger"
        className={cn("size-8", className)}
        onClick={(e) => {
          onClick?.(e);

          toggleSidebar();
        }}
        size="icon"
        variant="ghost"
        {...props}
      >
        <MenuIcon className="size-5" />
        <VisuallyHidden>
          {getLabel("accessibility.toggle_sidebar", "Toggle sidebar")}
        </VisuallyHidden>
      </Button>
    </Tooltip>
  );
}

export default SidebarTrigger;
