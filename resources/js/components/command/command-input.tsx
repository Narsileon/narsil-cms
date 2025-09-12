import { Command as CommandPrimitive } from "cmdk";

import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

type CommandInputProps = React.ComponentProps<
  typeof CommandPrimitive.Input
> & {};

function CommandInput({ className, ...props }: CommandInputProps) {
  return (
    <div
      data-slot="command-input-wrapper"
      className="flex h-9 items-center gap-2 border-b px-3"
    >
      <Icon className="size-4 shrink-0 opacity-50" name="search" />
      <CommandPrimitive.Input
        data-slot="command-input"
        className={cn(
          "flex h-9 w-full rounded-md bg-transparent py-3 text-sm outline-hidden",
          "disabled:cursor-not-allowed disabled:opacity-50",
          "placeholder:text-muted-foreground",
          className,
        )}
        {...props}
      />
    </div>
  );
}

export default CommandInput;
