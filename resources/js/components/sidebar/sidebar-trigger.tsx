import { Button, Tooltip, VisuallyHidden } from "@narsil-cms/blocks";
import { useLabels } from "@narsil-cms/components/labels";
import { cn } from "@narsil-cms/lib/utils";

import useSidebar from "./sidebar-context";

type SidebarTriggerProps = React.ComponentProps<typeof Button> & {};

function SidebarTrigger({ className, onClick, ...props }: SidebarTriggerProps) {
  const { trans } = useLabels();

  const { toggleSidebar } = useSidebar();

  return (
    <Tooltip tooltip={trans("accessibility.toggle_sidebar")}>
      <Button
        data-slot="sidebar-trigger"
        data-sidebar="trigger"
        className={cn("size-8", className)}
        icon="menu"
        size="icon"
        variant="ghost"
        onClick={(e) => {
          onClick?.(e);

          toggleSidebar();
        }}
        {...props}
      >
        <VisuallyHidden>
          {trans("accessibility.toggle_sidebar", "Toggle sidebar")}
        </VisuallyHidden>
      </Button>
    </Tooltip>
  );
}

export default SidebarTrigger;
