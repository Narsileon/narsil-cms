import { Select } from "radix-ui";
import { type ComponentProps } from "react";

import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";
import { type IconName } from "@narsil-cms/plugins/icons";

type SelectItemIndicatorProps = ComponentProps<typeof Select.ItemIndicator> & {
  icon?: IconName;
};

function SelectItemIndicator({
  children,
  className,
  icon = "check",
  ...props
}: SelectItemIndicatorProps) {
  return (
    <Select.ItemIndicator
      data-slot="select-item-indicator"
      className={cn(
        "absolute left-2 inline-flex items-center justify-center",
        className,
      )}
      {...props}
    >
      {children ?? <Icon className="size-4" name={icon} />}
    </Select.ItemIndicator>
  );
}

export default SelectItemIndicator;
