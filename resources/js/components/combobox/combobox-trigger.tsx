import { Combobox } from "@base-ui/react";
import { cn } from "@narsil-cms/lib/utils";
import { ChevronDownIcon } from "lucide-react";

function ComboboxTrigger({ children, className, ...props }: Combobox.Trigger.Props) {
  return (
    <Combobox.Trigger
      data-slot="combobox-trigger"
      className={cn("[&_svg:not([class*='size-'])]:size-4", className)}
      {...props}
    >
      {children}
      <ChevronDownIcon className="pointer-events-none size-4 text-muted-foreground" />
    </Combobox.Trigger>
  );
}

export default ComboboxTrigger;
