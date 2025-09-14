import { Select } from "radix-ui";

type SelectRootProps = React.ComponentProps<typeof Select.Root> & {};

function SelectRoot({ ...props }: SelectRootProps) {
  return <Select.Root data-slot="select-root" {...props} />;
}

export default SelectRoot;
