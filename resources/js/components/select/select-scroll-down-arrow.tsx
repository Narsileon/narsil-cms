import { Select } from "@base-ui/react/select";
import { Icon } from "@narsil-cms/blocks/icon";
import { cn } from "@narsil-cms/lib/utils";

function SelectScrollDownArrow({ children, className, ...props }: Select.ScrollDownArrow.Props) {
  return (
    <Select.ScrollDownArrow
      data-slot="select-scroll-down-arrow"
      className={cn(
        "bottom-0 z-10 flex w-full cursor-default items-center justify-center bg-popover py-1",
        "[&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    >
      {children ?? <Icon className="size-4" name="chevron-down" />}
    </Select.ScrollDownArrow>
  );
}

export default SelectScrollDownArrow;
