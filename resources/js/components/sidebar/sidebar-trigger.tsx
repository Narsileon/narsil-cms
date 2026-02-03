import { Button } from "@narsil-cms/components/button";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { Tooltip } from "@narsil-cms/components/tooltip";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";
import useSidebar from "./sidebar-context";

function SidebarTrigger({ className, onClick, ...props }: ComponentProps<typeof Button>) {
  const { trans } = useLocalization();
  const { toggleSidebar } = useSidebar();

  const tooltip = trans("accessibility.toggle_sidebar");

  return (
    <Tooltip tooltip={tooltip}>
      <Button
        data-slot="sidebar-trigger"
        data-sidebar="trigger"
        className={cn("size-8", className)}
        size="icon"
        variant="ghost"
        onClick={(event) => {
          onClick?.(event);

          toggleSidebar();
        }}
        {...props}
      >
        <Icon name="menu" />
        <span className="sr-only">{tooltip}</span>
      </Button>
    </Tooltip>
  );
}

export default SidebarTrigger;
