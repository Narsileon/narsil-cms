import { Select } from "radix-ui";

import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";
import { type IconName } from "@narsil-cms/plugins/icons";

type SelectScrollDownButtonProps = React.ComponentProps<
  typeof Select.ScrollDownButton
> & {
  icon?: IconName;
};

function SelectScrollDownButton({
  children,
  className,
  icon = "chevron-down",
  ...props
}: SelectScrollDownButtonProps) {
  return (
    <Select.ScrollDownButton
      data-slot="select-scroll-down-button"
      className={cn(
        "flex cursor-pointer items-center justify-center py-1",
        className,
      )}
      {...props}
    >
      {children ?? <Icon className="size-4" name={icon} />}
    </Select.ScrollDownButton>
  );
}

export default SelectScrollDownButton;
