import { cn } from "@narsil-cms/lib/utils";
import { Command } from "cmdk";
import { type ComponentProps } from "react";

type CommandSeparatorProps = ComponentProps<typeof Command.Separator>;

function CommandSeparator({ className, ...props }: CommandSeparatorProps) {
  return (
    <Command.Separator
      data-slot="command-separator"
      className={cn("-mx-1 h-px bg-border", className)}
      {...props}
    />
  );
}

export default CommandSeparator;
