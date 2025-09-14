import { Command } from "cmdk";

import { cn } from "@narsil-cms/lib/utils";

type CommandItemProps = React.ComponentProps<typeof Command.Item> & {};

function CommandItem({ className, ...props }: CommandItemProps) {
  return (
    <Command.Item
      data-slot="command-item"
      className={cn(
        "relative flex h-9 cursor-pointer items-center gap-2 rounded-md px-2 py-1.5 text-sm outline-hidden select-none",
        "data-[disabled=true]:pointer-events-none data-[disabled=true]:opacity-50",
        "data-[selected=true]:bg-accent data-[selected=true]:text-accent-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default CommandItem;
