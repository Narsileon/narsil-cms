import { cn } from "@narsil-cms/lib/utils";
import { Command } from "cmdk";
import { type ComponentProps } from "react";

type CommandListProps = ComponentProps<typeof Command.List>;

function CommandList({ className, ...props }: CommandListProps) {
  return (
    <Command.List
      data-slot="command-list"
      className={cn("max-h-[300px] scroll-py-1 overflow-y-auto overflow-x-hidden", className)}
      {...props}
    />
  );
}

export default CommandList;
