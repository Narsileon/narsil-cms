import { Select } from "radix-ui";

type SelectItemTextProps = React.ComponentProps<typeof Select.ItemText> & {};

function SelectItemText({ ...props }: SelectItemTextProps) {
  return <Select.ItemText {...props} />;
}

export default SelectItemText;
