import { Button } from "@narsil-cms/blocks/button";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { useLocalization } from "@narsil-cms/components/localization";
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
        icon="menu"
        size="icon"
        variant="ghost"
        onClick={(event) => {
          onClick?.(event);

          toggleSidebar();
        }}
        {...props}
      >
        <span className="sr-only">{tooltip}</span>
      </Button>
    </Tooltip>
  );
}

export default SidebarTrigger;
