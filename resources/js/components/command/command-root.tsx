import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Command as CommandPrimitive } from "cmdk";

type CommandRootProps = React.ComponentProps<typeof CommandPrimitive> & {};

function CommandRoot({ className, ...props }: CommandRootProps) {
  return (
    <CommandPrimitive
      data-slot="command-root"
      className={cn(
        "bg-popover text-popover-foreground flex h-full w-full flex-col overflow-hidden rounded-xl",
        className,
      )}
      {...props}
    />
  );
}

export default CommandRoot;
