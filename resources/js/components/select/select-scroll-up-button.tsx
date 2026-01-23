import { Icon } from "@narsil-cms/blocks/icon";
import { cn } from "@narsil-cms/lib/utils";
import { type IconName } from "@narsil-cms/repositories/icons";
import { Select } from "radix-ui";
import { type ComponentProps } from "react";

type SelectScrollUpButtonProps = ComponentProps<typeof Select.ScrollUpButton> & {
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
      className={cn("flex cursor-pointer items-center justify-center py-1", className)}
      {...props}
    >
      {children ?? <Icon className="size-4" name={icon} />}
    </Select.ScrollUpButton>
  );
}

export default SelectScrollUpButton;
