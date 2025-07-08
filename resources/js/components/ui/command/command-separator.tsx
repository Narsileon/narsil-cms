import { cn } from "@/lib/utils";
import { Command as CommandPrimitive } from "cmdk";

type CommandSeparatorProps = React.ComponentProps<
  typeof CommandPrimitive.Separator
> & {};

function CommandSeparator({ className, ...props }: CommandSeparatorProps) {
  return (
    <CommandPrimitive.Separator
      data-slot="command-separator"
      className={cn("bg-border -mx-1 h-px", className)}
      {...props}
    />
  );
}

export default CommandSeparator;
