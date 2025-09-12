import { Input } from "@narsil-cms/components/input";
import { cn } from "@narsil-cms/lib/utils";

type SidebarInputProps = React.ComponentProps<typeof Input> & {};

function SidebarInput({ className, ...props }: SidebarInputProps) {
  return (
    <Input
      data-slot="sidebar-input"
      data-sidebar="input"
      className={cn("h-8 w-full bg-background shadow-none", className)}
      {...props}
    />
  );
}

export default SidebarInput;
