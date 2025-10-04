import { type ComponentProps } from "react";

import { Button, Tooltip, VisuallyHidden } from "@narsil-cms/blocks";
import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";

import useSidebar from "./sidebar-context";

type SidebarTriggerProps = ComponentProps<typeof Button>;

function SidebarTrigger({ className, onClick, ...props }: SidebarTriggerProps) {
  const { trans } = useLocalization();
  const { toggleSidebar } = useSidebar();

  const tooltip = trans("accessibility.toggle_sidebar");

  return (
    <Tooltip tooltip={tooltip}>
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
        <VisuallyHidden>{tooltip}</VisuallyHidden>
      </Button>
    </Tooltip>
  );
}

export default SidebarTrigger;
