import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Input } from "@narsil-cms/components/ui/input";

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
