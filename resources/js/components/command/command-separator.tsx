import { Command } from "cmdk";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type CommandSeparatorProps = ComponentProps<typeof Command.Separator> & {};

function CommandSeparator({ className, ...props }: CommandSeparatorProps) {
  return (
    <Command.Separator
      data-slot="command-separator"
      className={cn("bg-border -mx-1 h-px", className)}
      {...props}
    />
  );
}

export default CommandSeparator;
