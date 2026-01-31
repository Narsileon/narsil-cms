import { Separator as SeparatorPrimitive } from "@base-ui/react/separator";
import { cn } from "@narsil-cms/lib/utils";

function Separator({ className, orientation = "horizontal", ...props }: SeparatorPrimitive.Props) {
  return (
    <SeparatorPrimitive
      data-slot="separator"
      className={cn(
        "shrink-0 bg-border data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full data-[orientation=vertical]:w-px data-[orientation=vertical]:self-stretch",
        className,
      )}
      orientation={orientation}
      {...props}
    />
  );
}

export default Separator;
