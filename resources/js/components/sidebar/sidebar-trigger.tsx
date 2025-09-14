import { Tooltip } from "@narsil-cms/blocks";
import { ButtonRoot } from "@narsil-cms/components/button";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import { VisuallyHiddenRoot } from "@narsil-cms/components/visually-hidden";
import { cn } from "@narsil-cms/lib/utils";

import useSidebar from "./sidebar-context";

type SidebarTriggerProps = React.ComponentProps<typeof ButtonRoot> & {};

function SidebarTrigger({ className, onClick, ...props }: SidebarTriggerProps) {
  const { trans } = useLabels();

  const { toggleSidebar } = useSidebar();

  return (
    <Tooltip tooltip={trans("accessibility.toggle_sidebar")}>
      <ButtonRoot
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
      </ButtonRoot>
    </Tooltip>
  );
}

export default SidebarTrigger;
