import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import { PanelLeftIcon } from "lucide-react";
import { VisuallyHidden } from "@/components/ui/visually-hidden";
import useSidebar from "./sidebar-context";
import useTranslationsStore from "@/stores/translations-store";
import {
  Tooltip,
  TooltipContent,
  TooltipTrigger,
} from "@/components/ui/tooltip";
import type { ButtonProps } from "@/components/ui/button";

export type SidebarTriggerProps = ButtonProps & {};

function SidebarTrigger({ className, onClick, ...props }: SidebarTriggerProps) {
  const { trans } = useTranslationsStore();

  const { toggleSidebar } = useSidebar();

  return (
    <Tooltip>
      <TooltipTrigger asChild={true}>
        <Button
          data-slot="sidebar-trigger"
          data-sidebar="trigger"
          className={cn("size-7", className)}
          onClick={(e) => {
            onClick?.(e);

            toggleSidebar();
          }}
          size="icon"
          variant="ghost"
          {...props}
        >
          <PanelLeftIcon />
          <VisuallyHidden>
            {trans("accessibility.toggle_sidebar", "Toggle sidebar")}
          </VisuallyHidden>
        </Button>
      </TooltipTrigger>
      <TooltipContent>
        {trans("accessibility.toggle_sidebar", "Toggle sidebar")}
      </TooltipContent>
    </Tooltip>
  );
}

export default SidebarTrigger;
