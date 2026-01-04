import { Button } from "@narsil-cms/blocks/button";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { VisuallyHidden } from "@narsil-cms/blocks/visually-hidden";
import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";
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
        onClick={(event) => {
          onClick?.(event);

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
