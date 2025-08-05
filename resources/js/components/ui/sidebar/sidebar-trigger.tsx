import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { VisuallyHidden } from "@narsil-cms/components/ui/visually-hidden";
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
        <Icon name="menu" />
        <VisuallyHidden>
          {getLabel("accessibility.toggle_sidebar", "Toggle sidebar")}
        </VisuallyHidden>
      </Button>
    </Tooltip>
  );
}

export default SidebarTrigger;
