import { RadioGroup } from "@base-ui/react/radio-group";
import { cn } from "@narsil-cms/lib/utils";

function RadioGroupRoot({ className, ...props }: RadioGroup.Props) {
  return (
    <RadioGroup
      data-slot="radio-group-root"
      className={cn("grid w-full gap-2", className)}
      {...props}
    />
  );
}

export default RadioGroupRoot;
