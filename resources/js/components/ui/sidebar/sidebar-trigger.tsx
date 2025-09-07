import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Tooltip } from "@narsil-cms/blocks";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { VisuallyHiddenRoot } from "@narsil-cms/components/ui/visually-hidden";
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
        onClick={(e) => {
          onClick?.(e);

          toggleSidebar();
        }}
        size="icon"
        variant="ghost"
        {...props}
      >
        <Icon name="menu" />
        <VisuallyHiddenRoot>
          {trans("accessibility.toggle_sidebar", "Toggle sidebar")}
        </VisuallyHiddenRoot>
      </Button>
    </Tooltip>
  );
}

export default SidebarTrigger;
