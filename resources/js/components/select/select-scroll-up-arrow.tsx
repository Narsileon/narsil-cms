import { Select } from "@base-ui/react/select";
import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

function SelectScrollUpArrow({ children, className, ...props }: Select.ScrollUpArrow.Props) {
  return (
    <Select.ScrollUpArrow
      data-slot="select-scroll-up-arrow"
      className={cn(
        "top-0 z-10 flex w-full cursor-default items-center justify-center bg-popover py-1",
        "[&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    >
      {children ?? <Icon className="size-4" name="chevron-up" />}
    </Select.ScrollUpArrow>
  );
}

export default SelectScrollUpArrow;
