import { CircleIcon } from "lucide-react";
import { cn } from "@/components";
import { Indicator, Item } from "@radix-ui/react-radio-group";

export type RadioGroupItemProps = React.ComponentProps<typeof Item> & {};

function RadioGroupItem({ className, ...props }: RadioGroupItemProps) {
  return (
    <Item
      data-slot="radio-group-item"
      className={cn(
        "border-input text-primary aspect-square size-4 shrink-0 rounded-full border shadow-xs transition-[color,box-shadow] outline-none",
        "aria-invalid:ring-destructive/20 aria-invalid:border-destructive",
        "dark:aria-invalid:ring-destructive/40 dark:bg-input/30",
        "disabled:cursor-not-allowed disabled:opacity-50",
        "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]",
        className,
      )}
      {...props}
    >
      <Indicator
        data-slot="radio-group-indicator"
        className="relative flex items-center justify-center"
      >
        <CircleIcon className="fill-primary absolute top-1/2 left-1/2 size-2 -translate-x-1/2 -translate-y-1/2" />
      </Indicator>
    </Item>
  );
}

export default RadioGroupItem;
