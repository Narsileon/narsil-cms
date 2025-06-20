import { ChevronUpIcon } from "lucide-react";
import { cn } from "@/Components";
import { ScrollUpButton } from "@radix-ui/react-select";

export type SelectScrollUpButtonProps = React.ComponentProps<
  typeof ScrollUpButton
> & {};

function SelectScrollUpButton({
  className,
  ...props
}: SelectScrollUpButtonProps) {
  return (
    <ScrollUpButton
      data-slot="select-scroll-up-button"
      className={cn(
        "flex cursor-default items-center justify-center py-1",
        className,
      )}
      {...props}
    >
      <ChevronUpIcon className="size-4" />
    </ScrollUpButton>
  );
}

export default SelectScrollUpButton;
