import { Value } from "@radix-ui/react-select";

export type SelectValueProps = React.ComponentProps<typeof Value> & {};

function SelectValue({ ...props }: SelectValueProps) {
  return <Value data-slot="select-value" {...props} />;
}

export default SelectValue;
