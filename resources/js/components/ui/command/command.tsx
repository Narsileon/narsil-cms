import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Command as CommandPrimitive } from "cmdk";

type CommandProps = React.ComponentProps<typeof CommandPrimitive> & {};

function Command({ className, ...props }: CommandProps) {
  return (
    <CommandPrimitive
      data-slot="command"
      className={cn(
        "bg-popover text-popover-foreground flex h-full w-full flex-col overflow-hidden rounded-md",
        className,
      )}
      {...props}
    />
  );
}

export default Command;
