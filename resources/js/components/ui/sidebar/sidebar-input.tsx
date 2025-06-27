import { cn } from "@/lib/utils";
import { Input } from "@/components/ui/input";
import type { InputProps } from "@/components/ui/input";

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
