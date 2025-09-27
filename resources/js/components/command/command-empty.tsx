import { Command } from "cmdk";
import { type ComponentProps } from "react";

type CommandEmptyProps = ComponentProps<typeof Command.Empty> & {};

function CommandEmpty({ ...props }: CommandEmptyProps) {
  return (
    <Command.Empty
      data-slot="command-empty"
      className="py-4 text-center"
      {...props}
    />
  );
}

export default CommandEmpty;
