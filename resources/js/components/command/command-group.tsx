import { cn } from "@narsil-cms/lib/utils";
import { Command } from "cmdk";
import { type ComponentProps } from "react";

type CommandGroupProps = ComponentProps<typeof Command.Group>;

function CommandGroup({ className, ...props }: CommandGroupProps) {
  return (
    <Command.Group
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
