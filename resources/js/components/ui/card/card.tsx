import { cn } from "@narsil-cms/lib/utils";

type CardProps = React.ComponentProps<"div"> & {};

function Card({ className, ...props }: CardProps) {
  return (
    <div
      data-slot="card"
      className={cn(
        "bg-card text-card-foreground flex flex-col rounded-xl border shadow-sm",
        className,
      )}
      {...props}
    />
  );
}

export default Card;
