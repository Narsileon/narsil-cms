import { cn } from "@narsil-cms/lib/utils";
import { Command as CommandPrimitive } from "cmdk";

type CommandGroupProps = React.ComponentProps<
  typeof CommandPrimitive.Group
> & {};

function CommandGroup({ className, ...props }: CommandGroupProps) {
  return (
    <CommandPrimitive.Group
      data-slot="command-group"
      className={cn(
        "text-foreground overflow-hidden p-1",
        "[&_[cmdk-group-heading]]:text-muted-foreground [&_[cmdk-group-heading]]:px-2 [&_[cmdk-group-heading]]:py-1.5 [&_[cmdk-group-heading]]:text-xs [&_[cmdk-group-heading]]:font-medium",
        className,
      )}
      {...props}
    />
  );
}

export default CommandGroup;
