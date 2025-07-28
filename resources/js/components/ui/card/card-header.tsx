import { cn } from "@narsil-cms/lib/utils";

type CardHeaderProps = React.ComponentProps<"div"> & {};

function CardHeader({ className, ...props }: CardHeaderProps) {
  return (
    <div
      data-slot="card-header"
      className={cn(
        "@container/card-header",
        "grid auto-rows-min grid-rows-[auto_auto] items-start px-6 pt-3 [.border-b]:pb-3",
        "has-data-[slot=card-action]:grid-cols-[1fr_auto]",
        className,
      )}
      {...props}
    />
  );
}

export default CardHeader;
