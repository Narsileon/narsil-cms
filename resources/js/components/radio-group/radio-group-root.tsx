import { RadioGroup } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type RadioGroupRootProps = React.ComponentProps<typeof RadioGroup.Root> & {};

function RadioGroupRoot({ className, ...props }: RadioGroupRootProps) {
  return (
    <RadioGroup.Root
      data-slot="radio-group-root"
      className={cn("grid gap-3", className)}
      {...props}
    />
  );
}

export default RadioGroupRoot;
