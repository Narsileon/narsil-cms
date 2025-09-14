import { Select } from "radix-ui";

import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

type SelectScrollDownButtonProps = React.ComponentProps<
  typeof Select.ScrollDownButton
> & {};

function SelectScrollDownButton({
  className,
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
      <Icon className="size-4" name="chevron-down" />
    </Select.ScrollDownButton>
  );
}

export default SelectScrollDownButton;
