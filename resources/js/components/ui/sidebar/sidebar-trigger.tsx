import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import { MenuIcon } from "lucide-react";
import { Tooltip } from "@/components/ui/tooltip";
import { VisuallyHidden } from "@/components/ui/visually-hidden";
import useSidebar from "./sidebar-context";
import useTranslationsStore from "@/stores/translations-store";

type SidebarTriggerProps = React.ComponentProps<typeof Button> & {};

function SidebarTrigger({ className, onClick, ...props }: SidebarTriggerProps) {
  const { trans } = useTranslationsStore();

  const { toggleSidebar } = useSidebar();

  return (
    <Tooltip tooltip={trans("accessibility.toggle_sidebar", "Toggle sidebar")}>
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
        <MenuIcon className="size-5" />
        <VisuallyHidden>
          {trans("accessibility.toggle_sidebar", "Toggle sidebar")}
        </VisuallyHidden>
      </Button>
    </Tooltip>
  );
}

export default SidebarTrigger;
