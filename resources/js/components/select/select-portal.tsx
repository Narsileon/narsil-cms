import { Select } from "radix-ui";

type SelectPortalProps = React.ComponentProps<typeof Select.Portal> & {};

function SelectPortal({ ...props }: SelectPortalProps) {
  return <Select.Portal data-slot="select-portal" {...props} />;
}

export default SelectPortal;
