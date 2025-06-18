import { cn } from "@/Components";

export type CardProps = React.ComponentProps<"div"> & {};

function Card({ className, ...props }: CardProps) {
  return (
    <div
      className={cn(
        "flex flex-col gap-6 rounded-xl border py-6 shadow-sm",
        "bg-card text-card-foreground",
        className,
      )}
      data-slot="card"
      {...props}
    />
  );
}

export default Card;
