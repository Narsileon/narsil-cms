import { Select } from "radix-ui";
import { type ComponentProps } from "react";

import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";
import { type IconName } from "@narsil-cms/plugins/icons";

type SelectScrollUpButtonProps = ComponentProps<
  typeof Select.ScrollUpButton
> & {
  icon?: IconName;
};

function SelectScrollUpButton({
  children,
  className,
  icon = "chevron-up",
  ...props
}: SelectScrollUpButtonProps) {
  return (
    <Select.ScrollUpButton
      data-slot="select-scroll-up-button"
      className={cn(
        "flex cursor-pointer items-center justify-center py-1",
        className,
      )}
      {...props}
    >
      {children ?? <Icon className="size-4" name={icon} />}
    </Select.ScrollUpButton>
  );
}

export default SelectScrollUpButton;
