import { cn } from "@narsil-cms/lib/utils";

type BuilderSeparatorProps = React.ComponentProps<"div"> & {};

function BuilderSeparator({ className, ...props }: BuilderSeparatorProps) {
  return (
    <div className={cn("h-4 border-x border-dashed", className)} {...props} />
  );
}

export default BuilderSeparator;
