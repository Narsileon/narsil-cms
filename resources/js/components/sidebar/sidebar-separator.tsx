import { Separator } from "@narsil-cms/components/separator";
import { cn } from "@narsil-cms/lib/utils";

type SidebarSeparatorProps = React.ComponentProps<typeof Separator> & {};

function SidebarSeparator({ className, ...props }: SidebarSeparatorProps) {
  return (
    <Separator
      data-slot="sidebar-separator"
      data-sidebar="separator"
      className={cn("mx-2 w-auto bg-sidebar-border", className)}
      {...props}
    />
  );
}

export default SidebarSeparator;
