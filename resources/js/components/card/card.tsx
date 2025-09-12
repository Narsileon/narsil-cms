import { cn } from "@narsil-cms/lib/utils";

type CardProps = React.ComponentProps<"div"> & {};

function Card({ className, ...props }: CardProps) {
  return (
    <div
      data-slot="card"
      className={cn(
        "flex flex-col rounded-md border bg-card text-card-foreground shadow-sm",
        className,
      )}
      {...props}
    />
  );
}

export default Card;
