import { cn } from "@/lib/utils";

export type CardProps = React.ComponentProps<"div"> & {};

function Card({ className, ...props }: CardProps) {
  return (
    <div
      data-slot="card"
      className={cn(
        "bg-card text-card-foreground flex flex-col gap-4 rounded-xl border py-4 shadow-sm",
        className,
      )}
      {...props}
    />
  );
}

export default Card;
