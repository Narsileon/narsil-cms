import { cn } from "@/components";
import { RadioGroup as RadioGroupPrimitive } from "radix-ui";

export type RadioGroupProps = React.ComponentProps<
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
