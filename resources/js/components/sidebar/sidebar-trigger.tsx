import { Button } from "@narsil-ui/components/button";
import { Icon } from "@narsil-ui/components/icon";
import { Tooltip } from "@narsil-ui/components/tooltip";
import { useTranslator } from "@narsil-ui/components/translator";
import { cn } from "@narsil-ui/lib/utils";
import { type ComponentProps } from "react";
import useSidebar from "./sidebar-context";

function SidebarTrigger({ className, onClick, ...props }: ComponentProps<typeof Button>) {
  const { trans } = useTranslator();
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
