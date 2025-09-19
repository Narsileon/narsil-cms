import { Label } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type LabelRootProps = React.ComponentProps<typeof Label.Root> & {};

function LabelRoot({ className, ...props }: LabelRootProps) {
  return (
    <Label.Root
      data-slot="label-root"
      className={cn(
        "flex items-center gap-1 leading-none font-medium select-none",
        "group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50",
        "peer-disabled:cursor-not-allowed peer-disabled:opacity-50",
        "[&>svg:first-child]:mr-1",
        className,
      )}
      {...props}
    />
  );
}

export default LabelRoot;
