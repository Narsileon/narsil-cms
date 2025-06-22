import { cn } from "@/lib/utils";

export type CardProps = React.ComponentProps<"div"> & {};

function Card({ className, ...props }: CardProps) {
  return (
    <div
      data-slot="card"
      className={cn(
        "flex flex-col gap-6 rounded-xl border py-6 shadow-sm",
        "bg-card text-card-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default Card;
