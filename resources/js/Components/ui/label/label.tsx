import { cn } from "@/Components";
import { Root } from "@radix-ui/react-label";

export type LabelProps = React.ComponentProps<typeof Root> & {};

function Label({ className, ...props }: LabelProps) {
  return (
    <Root
      className={cn(
        "flex items-center gap-2 text-sm leading-none font-medium select-none",
        "group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50",
        "peer-disabled:cursor-not-allowed peer-disabled:opacity-50",
        className,
      )}
      data-slot="label"
      {...props}
    />
  );
}

export default Label;
