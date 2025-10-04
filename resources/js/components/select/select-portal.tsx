import { Select } from "radix-ui";
import { type ComponentProps } from "react";

type SelectPortalProps = ComponentProps<typeof Select.Portal>;

function SelectPortal({ ...props }: SelectPortalProps) {
  return <Select.Portal data-slot="select-portal" {...props} />;
}

export default SelectPortal;
