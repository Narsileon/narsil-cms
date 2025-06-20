import { cn } from "@/components";
import { Label } from "@radix-ui/react-select";

export type SelectLabelProps = React.ComponentProps<typeof Label> & {};

function SelectLabel({ className, ...props }: SelectLabelProps) {
  return (
    <Label
      data-slot="select-label"
      className={cn("text-muted-foreground px-2 py-1.5 text-xs", className)}
      {...props}
    />
  );
}

export default SelectLabel;
