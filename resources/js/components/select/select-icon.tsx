import { Select } from "radix-ui";
import { type ComponentProps } from "react";

import { Icon } from "@narsil-cms/components/icon";
import { type IconName } from "@narsil-cms/plugins/icons";

type SelectIconProps = ComponentProps<typeof Select.Icon> & {
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
