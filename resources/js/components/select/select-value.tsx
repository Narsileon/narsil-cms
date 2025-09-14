import { Select } from "radix-ui";

type SelectValueProps = React.ComponentProps<typeof Select.Value> & {};

function SelectValue({ ...props }: SelectValueProps) {
  return <Select.Value data-slot="select-value" {...props} />;
}

export default SelectValue;
