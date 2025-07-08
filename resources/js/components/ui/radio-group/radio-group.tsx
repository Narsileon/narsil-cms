import { cn } from "@/lib/utils";
import { RadioGroup as RadioGroupPrimitive } from "radix-ui";

type RadioGroupProps = React.ComponentProps<
  typeof RadioGroupPrimitive.Root
> & {};

function RadioGroup({ className, ...props }: RadioGroupProps) {
  return (
    <RadioGroupPrimitive.Root
      data-slot="radio-group"
      className={cn("grid gap-3", className)}
      {...props}
    />
  );
}

export default RadioGroup;
