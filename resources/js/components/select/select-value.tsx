import { Select } from "radix-ui";
import { type ComponentProps } from "react";

type SelectValueProps = ComponentProps<typeof Select.Value> & {};

function SelectValue({ ...props }: SelectValueProps) {
  return <Select.Value data-slot="select-value" {...props} />;
}

export default SelectValue;
