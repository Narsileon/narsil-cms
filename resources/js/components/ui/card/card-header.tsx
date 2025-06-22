import { cn } from "@/lib/utils";

export type CardHeaderProps = React.ComponentProps<"div"> & {};

function CardHeader({ className, ...props }: CardHeaderProps) {
  return (
    <div
      data-slot="card-header"
      className={cn(
        "@container/card-header",
        "grid auto-rows-min grid-rows-[auto_auto] items-start gap-1.5 px-6 [.border-b]:pb-6",
        "has-data-[slot=card-action]:grid-cols-[1fr_auto]",
        className,
      )}
      {...props}
    />
  );
}

export default CardHeader;
