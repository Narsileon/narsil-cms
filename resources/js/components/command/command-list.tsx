import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Command as CommandPrimitive } from "cmdk";

type CommandListProps = React.ComponentProps<typeof CommandPrimitive.List> & {};

function CommandList({ className, ...props }: CommandListProps) {
  return (
    <CommandPrimitive.List
      data-slot="command-list"
      className={cn(
        "max-h-[300px] scroll-py-1 overflow-x-hidden overflow-y-auto",
        className,
      )}
      {...props}
    />
  );
}

export default CommandList;
