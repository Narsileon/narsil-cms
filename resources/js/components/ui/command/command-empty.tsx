import { Command as CommandPrimitive } from "cmdk";

export type CommandEmptyProps = React.ComponentProps<
  typeof CommandPrimitive.Empty
> & {};

function CommandEmpty({ ...props }: CommandEmptyProps) {
  return (
    <CommandPrimitive.Empty
      data-slot="command-empty"
      className="py-6 text-center text-sm"
      {...props}
    />
  );
}

export default CommandEmpty;
