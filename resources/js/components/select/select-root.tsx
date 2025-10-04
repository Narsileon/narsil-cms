import { Select } from "radix-ui";
import { type ComponentProps } from "react";

type SelectRootProps = ComponentProps<typeof Select.Root>;

function SelectRoot({ ...props }: SelectRootProps) {
  return <Select.Root data-slot="select-root" {...props} />;
}

export default SelectRoot;
