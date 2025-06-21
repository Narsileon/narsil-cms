import { Select as SelectPrimitive } from "radix-ui";

export type SelectProps = React.ComponentProps<
  typeof SelectPrimitive.Root
> & {};

function Select({ ...props }: SelectProps) {
  return <SelectPrimitive.Root data-slot="select" {...props} />;
}

export default Select;
