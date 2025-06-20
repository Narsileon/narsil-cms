import { cn } from "@/components";

export type CardDescriptionProps = React.ComponentProps<"div"> & {};

function CardDescription({ className, ...props }: CardDescriptionProps) {
  return (
    <div
      className={cn("text-muted-foreground text-sm", className)}
      data-slot="card-description"
      {...props}
    />
  );
}

export default CardDescription;
