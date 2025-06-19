import { cn } from "@/Components/utils";
import { Input, InputProps } from "@/Components/ui/input";

export type SidebarInputProps = InputProps & {};

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
