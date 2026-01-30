import { PreviewCard } from "@base-ui/react/preview-card";
import { cn } from "@narsil-cms/lib/utils";

function PreviewCardPositioner({
  className,
  align = "center",
  alignOffset = 4,
  side = "bottom",
  sideOffset = 4,
  ...props
}: PreviewCard.Positioner.Props) {
  return (
    <PreviewCard.Positioner
      data-slot="preview-card-positioner"
      className={cn("isolate z-50", className)}
      align={align}
      alignOffset={alignOffset}
      side={side}
      sideOffset={sideOffset}
      {...props}
    />
  );
}

export default PreviewCardPositioner;
