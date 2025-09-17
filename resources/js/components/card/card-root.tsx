import { cn } from "@narsil-cms/lib/utils";

type CardRootProps = React.ComponentProps<"div"> & {};

function CardRoot({ className, ...props }: CardRootProps) {
  return (
    <div
      data-slot="card-root"
      className={cn(
        "flex flex-col rounded-md border bg-card text-card-foreground shadow-sm",
        className,
      )}
      {...props}
    />
  );
}

export default CardRoot;
