import { cn } from "@narsil-cms/lib/utils";
import { Label as LabelPrimitive } from "radix-ui";

type LabelProps = React.ComponentProps<typeof LabelPrimitive.Root> & {};

function Label({ className, ...props }: LabelProps) {
  return (
    <LabelPrimitive.Root
      data-slot="label"
      className={cn(
        "flex items-center gap-2 text-sm leading-none font-medium select-none",
        "group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50",
        "peer-disabled:cursor-not-allowed peer-disabled:opacity-50",
        className,
      )}
      {...props}
    />
  );
}

export default Label;
