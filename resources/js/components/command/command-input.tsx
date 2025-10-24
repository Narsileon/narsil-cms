import { cn } from "@narsil-cms/lib/utils";
import { Command } from "cmdk";
import { type ComponentProps } from "react";

type CommandInputProps = ComponentProps<typeof Command.Input>;

function CommandInput({ className, ...props }: CommandInputProps) {
  return (
    <Command.Input
      data-slot="command-input"
      className={cn(
        "flex h-9 w-full rounded-md bg-transparent py-3 outline-hidden",
        "disabled:cursor-not-allowed disabled:opacity-50",
        "placeholder:text-muted-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default CommandInput;
