import { Select } from "radix-ui";

import { Icon } from "@narsil-cms/components/icon";
import { type IconName } from "@narsil-cms/plugins/icons";

type SelectIconProps = React.ComponentProps<typeof Select.Icon> & {
  icon?: IconName;
};

function SelectIcon({
  asChild = true,
  children,
  icon = "chevron-down",
  ...props
}: SelectIconProps) {
  return (
    <Select.Icon data-slot="select-icon" asChild={asChild} {...props}>
      {children ?? <Icon name={icon} />}
    </Select.Icon>
  );
}

export default SelectIcon;
