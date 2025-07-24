import { cn } from "@narsil-cms/lib/utils";
import { Command as CommandPrimitive } from "cmdk";
import { SearchIcon } from "lucide-react";

type CommandInputProps = React.ComponentProps<
  typeof CommandPrimitive.Input
> & {};

function CommandInput({ className, ...props }: CommandInputProps) {
  return (
    <div
      data-slot="command-input-wrapper"
      className="flex h-9 items-center gap-2 border-b px-3"
    >
      <SearchIcon className="size-4 shrink-0 opacity-50" />
      <CommandPrimitive.Input
        data-slot="command-input"
        className={cn(
          "flex h-10 w-full rounded-md bg-transparent py-3 text-sm outline-hidden",
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
