import { Command as CommandPrimitive } from "cmdk";

import { cn } from "@narsil-cms/lib/utils";

type CommandGroupProps = React.ComponentProps<
  typeof CommandPrimitive.Group
> & {};

function CommandGroup({ className, ...props }: CommandGroupProps) {
  return (
    <CommandPrimitive.Group
      data-slot="command-group"
      className={cn(
        "overflow-hidden p-1 text-foreground",
        "[&_[cmdk-group-heading]]:px-2 [&_[cmdk-group-heading]]:py-1.5 [&_[cmdk-group-heading]]:text-xs [&_[cmdk-group-heading]]:font-medium [&_[cmdk-group-heading]]:text-muted-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default CommandGroup;
