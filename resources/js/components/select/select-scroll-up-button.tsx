import { Select } from "radix-ui";

import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

type SelectScrollUpButtonProps = React.ComponentProps<
  typeof Select.ScrollUpButton
> & {};

function SelectScrollUpButton({
  className,
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
      <Icon className="size-4" name="chevron-up" />
    </Select.ScrollUpButton>
  );
}

export default SelectScrollUpButton;
