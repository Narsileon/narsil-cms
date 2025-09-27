import { Select } from "radix-ui";
import { type ComponentProps } from "react";

type SelectItemTextProps = ComponentProps<typeof Select.ItemText> & {};

function SelectItemText({ ...props }: SelectItemTextProps) {
  return <Select.ItemText {...props} />;
}

export default SelectItemText;
