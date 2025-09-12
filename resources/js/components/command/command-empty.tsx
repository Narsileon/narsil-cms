import { Command as CommandPrimitive } from "cmdk";

type CommandEmptyProps = React.ComponentProps<
  typeof CommandPrimitive.Empty
> & {};

function CommandEmpty({ ...props }: CommandEmptyProps) {
  return (
    <CommandPrimitive.Empty
      data-slot="command-empty"
      className="py-4 text-center text-sm"
      {...props}
    />
  );
}

export default CommandEmpty;
