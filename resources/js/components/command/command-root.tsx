import { cn } from "@narsil-cms/lib/utils";
import { Command } from "cmdk";
import { type ComponentProps } from "react";

type CommandRootProps = ComponentProps<typeof Command>;

function CommandRoot({ className, ...props }: CommandRootProps) {
  return (
    <Command
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
