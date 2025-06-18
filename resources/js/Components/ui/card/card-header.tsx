import { cn } from "@/Components";

export type CardHeaderProps = React.ComponentProps<"div"> & {};

function CardHeader({ className, ...props }: CardHeaderProps) {
  return (
    <div
      className={cn(
        "@container/card-header",
        "grid auto-rows-min grid-rows-[auto_auto] items-start gap-1.5 px-6 [.border-b]:pb-6",
        "has-data-[slot=card-action]:grid-cols-[1fr_auto]",
        className,
      )}
      data-slot="card-header"
      {...props}
    />
  );
}

export default CardHeader;
