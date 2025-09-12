import { SeparatorRoot } from "@narsil-cms/components/separator";
import { cn } from "@narsil-cms/lib/utils";

type SidebarSeparatorProps = React.ComponentProps<typeof SeparatorRoot> & {};

function SidebarSeparator({ className, ...props }: SidebarSeparatorProps) {
  return (
    <SeparatorRoot
      data-slot="sidebar-separator"
      data-sidebar="separator"
      className={cn("mx-2 w-auto bg-sidebar-border", className)}
      {...props}
    />
  );
}

export default SidebarSeparator;
