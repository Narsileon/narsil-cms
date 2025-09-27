import { Command } from "cmdk";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type CommandRootProps = ComponentProps<typeof Command> & {};

function CommandRoot({ className, ...props }: CommandRootProps) {
  return (
    <Command
      data-slot="command-root"
      className={cn(
        "flex h-full w-full flex-col overflow-hidden rounded-xl bg-popover text-popover-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default CommandRoot;
