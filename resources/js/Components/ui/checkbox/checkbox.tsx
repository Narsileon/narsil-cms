import { CheckIcon } from "lucide-react";
import { cn } from "@/Components";
import { Indicator, Root } from "@radix-ui/react-checkbox";

export type CheckboxProps = React.ComponentProps<typeof Root> & {};

function Checkbox({ className, ...props }: React.ComponentProps<typeof Root>) {
  return (
    <Root
      data-slot="checkbox"
      className={cn(
        "peer border-input size-4 shrink-0 rounded-[4px] border shadow-xs transition-shadow outline-none",
        "aria-invalid:border-destructive aria-invalid:ring-destructive/20",
        "dark:aria-invalid:ring-destructive/40",
        "dark:bg-input/30 data-[state=checked]:bg-primary",
        "data-[state=checked]:text-primary-foreground dark:data-[state=checked]:bg-primary data-[state=checked]:border-primary",
        "disabled:cursor-not-allowed disabled:opacity-50",
        "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]",
        className,
      )}
      {...props}
    >
      <Indicator
        data-slot="checkbox-indicator"
        className="flex items-center justify-center text-current transition-none"
      >
        <CheckIcon className="size-3.5" />
      </Indicator>
    </Root>
  );
}

export default Checkbox;
