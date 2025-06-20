import { ChevronDownIcon } from "lucide-react";
import { cn } from "@/components";
import { ScrollDownButton } from "@radix-ui/react-select";

export type SelectScrollDownButtonProps = React.ComponentProps<
  typeof ScrollDownButton
> & {};

function SelectScrollDownButton({
  className,
  ...props
}: SelectScrollDownButtonProps) {
  return (
    <ScrollDownButton
      data-slot="select-scroll-down-button"
      className={cn(
        "flex cursor-default items-center justify-center py-1",
        className,
      )}
      {...props}
    >
      <ChevronDownIcon className="size-4" />
    </ScrollDownButton>
  );
}

export default SelectScrollDownButton;
