import { cn } from "@/components";
import { Root } from "@radix-ui/react-radio-group";

export type RadioGroupProps = React.ComponentProps<typeof Root> & {};

function RadioGroup({ className, ...props }: RadioGroupProps) {
  return (
    <Root
      data-slot="radio-group"
      className={cn("grid gap-3", className)}
      {...props}
    />
  );
}

export default RadioGroup;
