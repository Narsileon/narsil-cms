import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Select as SelectPrimitive } from "radix-ui";

type SelectScrollUpButtonProps = React.ComponentProps<
  typeof SelectPrimitive.ScrollUpButton
> & {};

function SelectScrollUpButton({
  className,
  ...props
}: SelectScrollUpButtonProps) {
  return (
    <SelectPrimitive.ScrollUpButton
      data-slot="select-scroll-up-button"
      className={cn(
        "flex cursor-pointer items-center justify-center py-1",
        className,
      )}
      {...props}
    >
      <Icon className="size-4" name="chevron-up" />
    </SelectPrimitive.ScrollUpButton>
  );
}

export default SelectScrollUpButton;
