import { Command } from "cmdk";

type CommandEmptyProps = React.ComponentProps<typeof Command.Empty> & {};

function CommandEmpty({ ...props }: CommandEmptyProps) {
  return (
    <Command.Empty
      data-slot="command-empty"
      className="py-4 text-center text-sm"
      {...props}
    />
  );
}

export default CommandEmpty;
