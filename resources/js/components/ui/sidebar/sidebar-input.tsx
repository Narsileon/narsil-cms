import { cn } from "@/lib/utils";
import { Input } from "@/components/ui/input";

type SidebarInputProps = React.ComponentProps<typeof Input> & {};

function SidebarInput({ className, ...props }: SidebarInputProps) {
  return (
    <Input
      data-slot="sidebar-input"
      data-sidebar="input"
      className={cn("bg-background h-8 w-full shadow-none", className)}
      {...props}
    />
  );
}

export default SidebarInput;
