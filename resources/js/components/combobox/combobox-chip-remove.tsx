import { Combobox } from "@base-ui/react";
import { Button } from "@narsil-cms/components/button";
import { cn } from "@narsil-cms/lib/utils";
import { XIcon } from "lucide-react";

function ComboboxChipRemove({
  className,
  render,
  ...props
}: Combobox.ChipRemove.Props & {
  showRemove?: boolean;
}) {
  return (
    <Combobox.ChipRemove
      data-slot="combobox-chip-remove"
      className={cn("-ml-1 opacity-50 hover:opacity-100", className)}
      render={
        render ?? (
          <Button variant="ghost" size="icon-sm">
            <XIcon className="pointer-events-none" />
          </Button>
        )
      }
      {...props}
    />
  );
}

export default ComboboxChipRemove;
