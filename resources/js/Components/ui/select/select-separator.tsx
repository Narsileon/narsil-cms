import { cn } from "@/Components";
import { Separator } from "@radix-ui/react-select";

export type SelectSeparatorProps = React.ComponentProps<typeof Separator> & {};

function SelectSeparator({ className, ...props }: SelectSeparatorProps) {
  return (
    <Separator
      data-slot="select-separator"
      className={cn("bg-border pointer-events-none -mx-1 my-1 h-px", className)}
      {...props}
    />
  );
}

export default SelectSeparator;
