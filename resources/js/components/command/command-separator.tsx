import { Command as CommandPrimitive } from "cmdk";

import { cn } from "@narsil-cms/lib/utils";

type CommandSeparatorProps = React.ComponentProps<
  typeof CommandPrimitive.Separator
> & {};

function CommandSeparator({ className, ...props }: CommandSeparatorProps) {
  return (
    <CommandPrimitive.Separator
      data-slot="command-separator"
      className={cn("-mx-1 h-px bg-border", className)}
      {...props}
    />
  );
}

export default CommandSeparator;
