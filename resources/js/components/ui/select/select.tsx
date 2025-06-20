import { Root } from "@radix-ui/react-select";

export type SelectProps = React.ComponentProps<typeof Root> & {};

function Select({ ...props }: SelectProps) {
  return <Root data-slot="select" {...props} />;
}

export default Select;
